### Installation
```
macos: brew install postgresql
ubuntu: apt install postgresql
windows: choco install postgresql
```
***
### Connection Postgres
```SQL
$ sudo apt-get install php-pgsql
$ psql {{ db_name }}
    bd_name=> ALTER USER {{ user_name }} with encrypted password 'password';
    bd_name=> \q;
$ sudo systemctl restart postgresql.service
```
config/database.php
```php
<?php

$db_connection = 'pgsql';
$host= 'localhost';
$db = 'test';
$user = 'novapc74';
$password = 'test';
$port = 5432;
```
index.php
```php
<?php

require_once __DIR__ . "/config/database.php";

function connect(string $host, string $db, string $user, string $password, int $port, string $db_connection): PDO
{
    try {
        $dsn = "$db_connection:host=$host;port=$port;dbname=$db;";
        return  new PDO(
            $dsn,
            $user,
            $password,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

$conn = connect($host, $db, $user, $password, $port, $db_connection);

$result = $conn->query("SELECT * FROM users");

// вывод содержимого таблицы
foreach ($result as $row) {
    echo "{$row['id']} {$row['first_name']} {$row['last_name']}" . PHP_EOL;
}
```
