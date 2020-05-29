## Init the project (first time)

```bash
make init
```

This command will:
- Set .env file
- Start containers
- Install dependencies
- Create a database

```bash
make fixtures
```
This command will:
- Install fixtures

## Then

If the project is already installed:

```bash
make up   # Start containers
#or
make down # Stop containers
```

> Now you can go to http://test.inter-invest.localhost:8080

## Info

```bash
make info # Get Container ID, Hosts...
```

## For OSX

```bash
make sync-start # Start files synchronization
make sync-stop  # Stop files synchronization
make sync-clean # Remove volume
make sync-logs  # Logs
```

## Makefile

```bash
make help # see all commands available
```
