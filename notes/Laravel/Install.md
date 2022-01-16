### Install
```
laravel new project
composer require laravel/ui
composer require laravelcollective/html

php artisan ui bootstrap --auth
npm install
npm run dev


```
***
### Images
```
{{asset('images/cube.png')}}
mix.copyDirectory('resources/images', 'public/images');

https://ru.stackoverflow.com/questions/535323/%D0%9A%D0%B0%D0%BA-%D0%BF%D0%BE%D0%BA%D0%B0%D0%B7%D1%8B%D0%B2%D0%B0%D1%82%D1%8C-%D0%BA%D0%B0%D1%80%D1%82%D0%B8%D0%BD%D0%BA%D0%B8-%D0%B2-blade-laravel
```
***
### add SQLite
```
touch database/database.sqlite
```
```php
'default' => env('DB_CONNECTION', 'sqlite')

'sqlite' => [
    'driver' => 'sqlite',
    'url' => env('DATABASE_URL'),
    'database' => __DIR__.'/../database/database.sqlite',
    'prefix' => '',
    'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
]
```
```
.env
DB_CONNECTION=sqlite
```
***

### rails/ui
```
$ npm install @rails/ujs
$ npm install
```
```
Затем добавьте в конец файла resources/js/app.js строчки:

const ujs = require('@rails/ujs');
ujs.start();

$ npm run watch

<a href="..." data-method="delete" rel="nofollow">Удалить</a>

<a href="..." data-confirm="Вы уверены?" data-method="delete" rel="nofollow">Удалить</a>

<input type="submit" value="Сохранить" data-disable-with="Сохраняем">

```

