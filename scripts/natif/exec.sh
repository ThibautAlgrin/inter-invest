#!/bin/bash

ACTION=$1

CONSOLE='php bin/console'
PATH_VHOST='/Users/thibaut/Sites/vhosts'
HOSTS_FILE="/etc/hosts"
HOSTS_TMP_FILE="/etc/hosts.tmp"

hosts=(
    "test.inter-invest.localhost"
)

execute() {
    $ACTION
}

no-implemented() {
    echo "Command not implemented"
}

#############
# DOCKER
#############

up() {
    sudo apachectl start
}

remove() {
    no-implemented
}

info() {
    echo -e "\n\033[35m==========  Infos  ==========\n\033[37m"

    echo -e "\033[33m Hosts:\033[37m"
    echo -e "\033[37m    - Monolitic:     \033[34m http://test.inter-invest.localhost\033[37m"
}

exec() {
    no-implemented
}

envs() {
    cp behat.yml.dist behat.yml
    brew services start httpd
    brew services start php
}

envs-remove() {
    brew services stop httpd
    brew services stop php
    sudo apachectl stop
    rm -rf public/build public/bundles public/js coverage
}

images-build() {
    REAL_PATH=$(realpath .)
    cat scripts/natif/http/vhost.conf >> ${PATH_VHOST}/inter-invest.localhost.conf

    if [ "$(uname -a | grep Darwin)" ]; then
        sed -i "" 's/PWD/'${REAL_PATH//\//\\/}'/g' ${PATH_VHOST}/inter-invest.localhost.conf
    else
        sed -i 's/PWD/'${REAL_PATH//\//\\/}'/g' ${PATH_VHOST}/inter-invest.localhost.conf
    fi
}

images-remove() {
    rm ${PATH_VHOST}/inter-invest.localhost.conf
}

networks-create() {
    no-implemented
}

networks-remove() {
    no-implemented
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
    no-implemented
}

volumes-create() {
    no-implemented
}

#############
# SYMFONY
#############

install() {
    cmd 'composer install'
}

populate() {
    cmd "$CONSOLE f:e:p --no-debug"
}

reset() {
    cmd "$CONSOLE f:e:r"
}

#############
# APP
#############

fixtures() {
     cmd "\
            rm -rf public/uploads/avatar/* public/uploads/event/* public/uploads/category/* &&\
            $CONSOLE d:d:d --force --env=test &&\
            $CONSOLE d:d:c --no-interaction --env=test &&\
            $CONSOLE d:s:u --force --env=test &&\
            $CONSOLE d:f:l --no-interaction --env=test &&\
            rm -rf var/log/* var/cache/*\
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
    cmd "vendor/bin/simple-phpunit"
}

tu_coverage() {
    cmd "vendor/bin/simple-phpunit --coverage-html=coverage/unit --coverage-xml=coverage/unit/coverage-xml --log-junit=coverage/unit/phpunit.junit.xml"
    cmd "vendor/bin/infection --threads=4 --coverage=coverage/unit --only-covered"
}

tf() {
    fixtures
    cmd "php -d memory_limit=-1 vendor/bin/behat --no-coverage --format progress --stop-on-failure"
}

tf_coverage() {
    fixtures
    cmd "php -d memory_limit=-1 vendor/bin/behat --format progress"
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
    cmd "./vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix --using-cache=no --verbose src"
    cmd "./vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix --using-cache=no --verbose tests"
}

phpmetrics() {
    cmd "phpdbg -qrr ./vendor/bin/phpmetrics --report-html=reports --exclude=vendor,bin,reports,tests,var,features,src/Kernel.php,src/DataFixtures,src/Migrations ./"
}

cmd() {
    bash -c "$1"
}

execute
