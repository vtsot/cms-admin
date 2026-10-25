# CMS admin
Admin section to manage website pages

## Requirements:
- php 8.4
- mysql 8

## Installation:

### Add a host 
edit /etc/hosts  
add a new hosts:
- cms-admin.local
- admin.cms-admin.local
- api.cms-admin.local


### Compile all docker images
see [Makefile](./makefile) for details

#### Build docker images
```bash
make docker-build
```

#### Run docker images
```bash
make docker-up
```

## Production image
The root [Dockerfile](./Dockerfile) builds self-contained images (code, vendors and built assets inside):
- `app` (default target) - php-fpm
- `nginx` - nginx with `public/`, proxies PHP to the `php-fpm` host

Run them with [docker-compose.prod.yaml](./docker-compose.prod.yaml):
```bash
cp .env.prod.local.dist .env.prod.local   # fill in passwords, APP_SECRET, domains, locales
docker compose -f docker-compose.prod.yaml --env-file .env.prod.local up -d --build
```
- the Symfony cache is rebuilt on every php-fpm start, so `LOCALES` / `DEFAULT_LOCALE` are taken from `.env.prod.local`
- migrations run on start while `RUN_MIGRATIONS=1`
- messenger worker: add `--profile worker`
- data lives in the named volumes `mysql`, `storage`, `sessions`, `uploaded`

### API doc 
- api.cms-admin.local/doc
- admin.cms-admin.local/api/doc
