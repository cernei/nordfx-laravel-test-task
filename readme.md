## Lottery app

### Installation

1) Run `git clone https://github.com/cernei/nordfx-laravel-test-task.git`
2) Run `cd nordfx-laravel-test-task/.docker`
3) Run `docker compose up`

Configuration assumes you have 8080 port available, otherwise you have to manually map container's port to available one on your machine in `docker.compose.yml` file

4) Wait until all containers are built and started. Look at the logs.
5) Naviate to `http://localhost:8080/install`

### Setup

 - `/install` - first endpoint you should navigate to install db, it also used to empty database when you want to retry test case 
 - `/add` - Page where you "buy" tickets.
 - `/launch` - Page where lottery draw happens.
 - `/add-test-case` Import 1 million tickets for test app under load
