# PHP Advent of Code

## Quickstart

```bash
$ cat env.example | sed "s/SESSION=/SESSION=$YOUR_SESSION_COOKIE/" > .env
$ docker-compose up -d
$ docker-compose exec app composer install
$ docker-compose exec app php run.php 2022 1
```

## Running tests

```bash
$ docker-compose exec app vendor/bin/phpunit
```

## Getting solutions

```bash
$ docker-compose exec app php run.php 2022 1
```
