# Task Management API

This application allows for managing tasks.

It uses the EasyAdminBundle as an interface for managing users and tasks.

### Setup

Set up the project by going into the docker folder and running the setup command:

```bash
cd docker
make setup
```

#### .env
Copy the environment file: .env.dist from symfony and rename it to .env:
```bash
cd ..
cp .env.dist .env
```

### Docker

Build the containers and/or run them inside the docker directory.
The following command creates the containers if they haven't been created already and runs the environment.

```bash
cd docker
make run
```

### Composer

Install the composer packages by running the following command in the docker directory:

```bash
make install
```

### Database

Set up the database and run the fixtures by executing the following command in the docker directory:

```bash
make reset-db-with-migrations-and-load-fixtures
```

### Login

Login to the admin interface by using the admin credentials mentioned in the .env
```bash
ADMIN_USER_EMAIL
ADMIN_USER_PASSWORD
```

The admin password can also be used to log in with each user, this is the development password.

### Admin Interface

Admins can manage users (create, read, update and delete)
Admins can manage tasks (create, read, update and delete)
Users can only see their own tasks

### Redis

All doctrine entities are caches with Redis.
This needs to be improved and tested, it is WIP.