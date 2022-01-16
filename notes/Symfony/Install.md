### Install
```
composer create-project symfony/skeleton MyProject

/* запуск локального сервера из MyProject*/

php -S localhost:8000 -t public

/* помошник для создания контроллеров */
composer require generator

composer require annotations
composer require jms/serializer-bundle
composer require friendsofsymfony/rest-bundle
```
### Настройка точки входа
```
php bin/console make:controller
```

### DB
```
composer require doctrine

/* DATABASE_URL="postgresql://db_UserNamer:db_PASSWORD@127.0.0.1:5432/db_Name?serverVersion=13&charset=utf8" */

DATABASE_URL="postgresql://novapc74:test@127.0.0.1:5432/symfonydb?serverVersion=13&charset=utf8"


composer require symfony/orm-pack
composer require --dev symfony/maker-bundle

php bin/console doctrine:database:create

php bin/console make:entity

php bin/console make:migration
php bin/console doctrine:migrations:migrate

php bin/console make:entity --regenerate /* для ручного добавления методов */

php bin/console make:controller ProductController /* создани е контроллера */
```

https://api-platform.com
