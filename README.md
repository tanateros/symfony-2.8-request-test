Request API
=====
My test task

Requirements
=====
* PHP >= 5.4
* MySQL >= 5.0
* Composer
* PHPUnit

Quick start
=====
Create in MySQL new user and database

    database_name: api_symf2
    database_user: api_symf2
    database_password: api_symf2123

* composer install
* php app/console doctrine:schema:update --force
* nohup php app/console server:start

Example
=====
Add request
* curl -XPOST http://127.0.0.1:8000/storeRequest/first -d '{"test":123}'

Search request
* curl -XGET http://127.0.0.1:8000/getRequest/?id=1&method=POST&route=first&ip=127.0.0.1&last_days=1&search=123

Tests
=====
phpunit -c app