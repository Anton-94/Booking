## Introduction

Docker4Symfony is a set of docker images optimized for symfony 5. Use `docker-compose.yml` file from the latest stable release to spin up local environment on Linux, Mac OS X and Windows.

## Stack

The Docker4Symfony stack consist of the following containers:

| Service name           | Versions                | Image                              |
| --------------------   | ------------------      | ---------------------------------- |
| [nginx]                | latest                  | [nginx:latest]                            |
| [php-fpm]              | 7.4                     | [php:7.4-fpm]                      |
| [php-cli]              | 7.4                     | [php:7.4-fpm]                      |
| [encore]               | 14                      | [node:14]                          |
| [mysql]                | 8                       | [mysql:8.0]                        |
| [pma]                  |                         | [phpmyadmin/phpmyadmin]            |
| [mailer]               |                         | [mailhog/mailhog]                  |
