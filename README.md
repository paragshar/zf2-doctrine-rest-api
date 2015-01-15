Zend Skeleton APIs using Doctrine
=======================

Introduction
------------
This is a simple, skeleton application providing REST APIs using the ZF2 and Doctrine. This application is meant to be used as a starting place for those looking to create REST APIs with ZF2, and using Doctrine for ORM support, and database access.

Installation
------------

Using Composer (recommended)
----------------------------
The recommended way to get a working copy of this project is to clone the repository
and use `composer` to install dependencies using the `create-project` command:

    curl -s https://getcomposer.org/installer | php --
    php composer.phar create-project -sdev --repository-url="https://packages.zendframework.com" zendframework/skeleton-application path/to/install

Alternately, clone the repository and manually invoke `composer` using the shipped
`composer.phar`:

    cd my/project/dir
    git clone git://github.com/paragshar/zf2-doctrine-rest-api.git
    cd zf2-doctrine-rest-api
    php composer.phar self-update
    php composer.phar install

(The `self-update` directive is to ensure you have an up-to-date `composer.phar`
available.)

You would then invoke `composer` to install dependencies per the previous
example.

Creating database using Doctrine Annotations
------------
Assuming that you have installed all the dependencies of this application by running "composer install", and having created a doctrine.local.php (structure similar to doctrine.global.php) in config/autoload directory with database configurations.

Run the following command from the root of your application. This command will read annotations present in your entities, and correspondingly create tables in the database specified in the config file (doctrine.local.php)

./vendor/bin/doctrine-module orm:schema-tool:create
