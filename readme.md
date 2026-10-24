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

### API doc 
- api.cms-admin.local/doc
- admin.cms-admin.local/api/doc
