#!/bin/bash

ACTION=$1
APP_DIR=$PWD

STACK_NAME=inter-invest
SERVICE_NAME=$STACK_NAME"_php-fpm.1"
CONTAINER_ID=$(docker container ls | grep $SERVICE_NAME | sed -e 's/^\(.\{12\}\).*/\1/')
HOSTS_FILE="/etc/hosts"
HOSTS_TMP_FILE="/etc/hosts.tmp"

CONSOLE='php bin/console'

networks=(
    "application"
    "database"
    "elk"
)

hosts=(
    "test.inter-invest.localhost"
)

execute() {
    $ACTION
}

#############
# DOCKER
#############

up() {
    echo -e "\n\033[35m==========  Deploying Stack  ==========\n\033[37m"

    if [ "$(uname -a | grep Darwin)" ]; then
        echo -e "\033[34m OSX Detected: Let's start docker-sync !\n\033[37m"
        docker-sync start
    fi

    env $(cat $APP_DIR/.docker | grep "^[A-Z]" | xargs) docker stack deploy -c $APP_DIR/docker-compose.yaml $STACK_NAME

    while [ -z $CONTAINER_ID ]
    do
        echo "Wait 5s"
        sleep 5s
        CONTAINER_ID=$(docker container ls | grep $SERVICE_NAME | sed -e 's/^\(.\{12\}\).*/\1/')
    done

    echo -e "\n\033[32m ✔ Success! Your stack is ready 🎉 \n\033[37m"
}

remove() {
    docker stack rm $STACK_NAME

    if [ "$(uname -a | grep Darwin)" ]; then
        docker-sync stop
    fi
    NB_CONTAINER=$(docker container ls | grep $STACK_NAME | wc -l)
    while [ $NB_CONTAINER -gt 0 ]
    do
        echo "Wait 5s"
        sleep 5s
        NB_CONTAINER=$(docker container ls | grep $STACK_NAME | wc -l)
    done
}

info() {
    echo -e "\n\033[35m==========  Infos  ==========\n\033[37m"

    echo -e "\033[33m Container ID: \033[34m$CONTAINER_ID\n\033[37m"

    echo -e "\033[33m Hosts:\033[37m"
    echo -e "\033[37m    - Elasticsearch: \033[34m http://localhost:9200\033[37m"
    echo -e "\033[37m    - Kibana:        \033[34m http://localhost:5601\033[37m"
    echo -e "\033[37m    - Thumbor:       \033[34m http://localhost:8888\n\033[37m"
    echo -e "\033[37m    - Monolitic:     \033[34m https://${hosts[0]}:8083\033[37m"

    echo -e "\n\033[33m To go inside the container, run: \033[37m\033[45m make exec \033[37m\033[49m 🐳"
}

exec() {
    docker exec -it $CONTAINER_ID bash
}

envs() {
    cp .docker.dist .docker
    cp behat.yml.dist behat.yml
    mkdir -p .data/database .data/logs/nginx
    REAL_PATH=$(realpath .)

    if [ "$(uname -a | grep Darwin)" ]; then
        sed -i "" 's/http:\/\/test.inter-invest.localhost\//http:\/\/test.inter-invest.localhost:8082\//g' behat.yml

        sed -i "" 's/DATABASE_URL=mysql:\/\/root:root@127.0.0.1:3306/DATABASE_URL=mysql:\/\/root:@database:3306/g' .env

        sed -i "" 's/ENV_DATA_DATABASE_PATH/.\/.data\/database/g' .docker
        sed -i "" 's/VOLUME_API_V2/unison-sync-inter-invest/g' .docker
        sed -i "" 's/_UNISON_STRATEGY/:nocopy/g' .docker
    else
        sed -i 's/http:\/\/test.inter-invest.localhost\//http:\/\/test.inter-invest.localhost:8082/g' behat.yml

        sed -i 's/DATABASE_URL=mysql:\/\/root:root@127.0.0.1:3306/DATABASE_URL=mysql:\/\/root:@database:3306/g' .env

        sed -i 's/ENV_DATA_DATABASE_PATH/\/data\/database/g' .docker
        sed -i 's/VOLUME_API_V2/'${REAL_PATH//\//\\/}'/g' .docker
        sed -i 's/_UNISON_STRATEGY//g' .docker
    fi
}

envs-remove() {
    rm -rf .docker behat.yml .docker-sync .data
    if [ "$(uname -a | grep Darwin)" ]; then
        sed -i "" 's/DATABASE_URL=mysql:\/\/root:@database:3306/DATABASE_URL=mysql:\/\/root:root@127.0.0.1:3306/g' .env
    else
        sed -i 's/DATABASE_URL=mysql:\/\/root:@database:3306/DATABASE_URL=mysql:\/\/root:root@127.0.0.1:3306/g' .env
    fi
    docker container stop $(docker container ls --filter name="ssh-agent" -q)
    docker container rm $(docker container ls -aq)
    docker volume rm $(docker volume ls -q)
}

certs-create() {
    sh scripts/docker/nginx/certs.sh
}

images-build() {
    echo -e "\n\033[35m==========  Building Docker images  ==========\n\033[37m"

    docker build -t php73 $PWD/scripts/docker/php/php73
}

images-remove() {
    sleep 5s
    docker image rm $(docker images php73 -q)
}

networks-create() {
    echo -e "\n\033[35m==========  Creating External Networks  ==========\n\033[37m"

    for i in ${networks[*]}; do
        if [ ! "$(docker network ls | grep ${i})" ]; then
            docker network create -d overlay ${i}
        fi
    done
}

networks-remove() {
    echo -e "\n\033[35m==========  Removing External Networks  ==========\n\033[37m"

    for i in ${networks[*]}; do
        if [ "$(docker network ls | grep ${i})" ]; then
            docker network rm ${i}
        fi
    done
}

hosts-add() {
    for i in ${hosts[*]}; do
        HOST="127.0.0.1       ${i}"
        grep -q -F "${HOST}" "${HOSTS_FILE}" || echo "${HOST}" >> "${HOSTS_FILE}"
    done
}

hosts-remove() {
    for i in ${hosts[*]}; do
        PATTERN="/${i}/d"
        sed "${PATTERN}" "${HOSTS_FILE}" > "${HOSTS_TMP_FILE}" && mv "${HOSTS_TMP_FILE}" "${HOSTS_FILE}"
    done
}

swarm-init() {
    docker swarm init
}

volumes-create() {
    echo -e "\n\033[35m==========  Creating External Volume (ssh)  ==========\n\033[37m"

    if [ ! "$(docker volume ls | grep ssh-agent-data)" ]; then
        docker run -u 1000 -d --restart always -v ssh-agent-data:/ssh --name=ssh-agent whilp/ssh-agent
    fi

    docker run -u 1000 --rm -v ssh-agent-data:/ssh -v $HOME:$HOME -it whilp/ssh-agent:latest ssh-add $HOME/.ssh/id_rsa

    echo -e "\033[32m ✔ Success\n\033[37m"
}

#############
# SYMFONY
#############

install() {
    cmd 'composer install'
}

update() {
    cmd 'composer update'
}

cache_clear() {
    cmd "$CONSOLE ca:cl"
}

#############
# APP
#############

fixtures() {
     cmd "\
          $CONSOLE d:d:d --force --env=test &&\
          $CONSOLE d:d:c --no-interaction --env=test &&\
          $CONSOLE d:s:u --force --env=test &&\
          $CONSOLE d:f:l --no-interaction --env=test &&\
          rm -rf public/uploads/avatar/* &&\
          rm -rf var/log/*\
      "
}

#############
# TEST
#############

tests() {
    tu
    tf
}

tu() {
    cmd "phpdbg -qrr vendor/bin/simple-phpunit"
}

tu_coverage() {
    cmd "phpdbg -qrr ./vendor/bin/simple-phpunit --coverage-html=coverage/unit --coverage-xml=coverage/unit/coverage-xml --log-junit=coverage/unit/phpunit.junit.xml"
    cmd "phpdbg -qrr vendor/bin/infection --threads=4 --coverage=coverage/unit --only-covered"
}

tf() {
    fixtures
    cmd "rm -rf var/log/*"
    cmd "phpdbg -d memory_limit=-1 -qrr vendor/bin/behat --no-coverage --format progress --stop-on-failure"
}

tf_coverage() {
    fixtures
    cmd "phpdbg -d memory_limit=-1 -qrr vendor/bin/behat --format progress"
}

#############
# AUDIT
#############

phpcs() {
    cmd "./vendor/bin/phpcs --standard=.phpcs.xml src"
}

phpcpd() {
    cmd "./vendor/sebastian/phpcpd/phpcpd src"
}

phpmd() {
    cmd "./vendor/phpmd/phpmd/src/bin/phpmd src text .phpmd.xml --exclude src/DataFixtures"
}

php_cs_fixer() {
    cmd "./vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix --dry-run --using-cache=no src/"
}

php_cs_fixer_apply() {
    cmd "./vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix --using-cache=no --verbose src/"
}

phpmetrics() {
    cmd "phpdbg -qrr ./vendor/bin/phpmetrics --report-html=reports --exclude=vendor,bin,reports,tests,var,features,src/Kernel.php,src/DataFixtures,src/Migrations ./"
}

cmd() {
    docker exec -it $CONTAINER_ID bash -c "$1"
}

execute
