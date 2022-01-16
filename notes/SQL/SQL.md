### DATABASE QUERIES
### Data types
```SQL
integer     типичный выбор для целых чисел
bigint      целое в большом диапазоне
numeric     специальный тип данных, подходящий под работу с деньгами. Обеспечивает высокую точность при расчетах.
timestamp   дата и время (без часового пояса)
date        дата (без времени суток)
time        время суток (без даты)
boolean     состояние: истина или ложь TRUE -> 't', 'true', 'y', 'yes', 'on', '1'
                                       FALSE -> 'f', 'false', 'n', 'no', 'off', '0'
varchar(n)  строка ограниченной переменной длины
text        строка неограниченной переменной длины

```
### Create table
```SQL
CREATE TABLE users (
    id bigint PRIMARY KEY GENERATED ALWAYS AS IDENTITY,
    first_name varchar(255) NOT NULL,
    last_name varchar(255) UNIQUE,
    description text
);
```
```SQL
CREATE TABLE products (
    id bigint PRIMARY KEY,
    name text,
    locale varchar,
    price numeric,
    UNIQUE(name, locale)
);
```
```SQL
CREATE TABLE orders (
    id bigint PRIMARY KEY,
    -- Тип внешнего ключа должен быть такой же,
    -- как у первичного в той таблице, куда ссылается внешний
    user_id bigint REFERENCES users (id),
    -- остальные поля
);
```
### Insert
```SQL
INSERT INTO users (first_name, last_name, description)
    VALUES ('Ivan', 'Ivanov', 'smart man');
```
```SQL
INSERT INTO users
    VALUES ('Ivan', 'Ivanov', 'smart man');
```
```SQL
INSERT INTO users (first_name, last_name, description)
    VALUES ('Ivan', 'Ivanov', 'smart man'),
            ('Peter', 'Petrov', 'good man')
            ('Ira', 'Makarova', 'fine girl');
```
### Update
```SQL
UPDATE users
    SET first_name = 'Nikolay', last_name = 'Sidorov'
    WHERE description = 'smart man';
```
```SQL
UPDATE courses
    SET name = 'new name'
    WHERE lessons_count > 3;
UPDATE courses
    SET name = 'another new name'
    WHERE lessons_count < 2;
```
```SQL
UPDATE courses
    SET name = 'new name'
    WHERE slug = 'bash' AND lessons_count > 3;
```
```SQL
UPDATE courses
    SET name = 'another new name'
    WHERE lessons_count < 2 OR lessons_count > 8;
```
```SQL
UPDATE courses SET name = 'another new name'
    WHERE (lessons_count < 2 AND lessons_count > 8) OR slug = 'linux';
```
### Delete data
```SQL
DELETE FROM courses WHERE slug = 'bash'; /* опасно использовать без WHERE !!! */
```
```SQL
TRUNCATE courses; /* полность очищает таблицу */
```
### Select
```SQL
SELECT * FROM users;
SELECT username, email FROM users;
SELECT * FROM users WHERE birthday < '2018-10-21';
SELECT * FROM users LIMIT 3;
SELECT * FROM users ORDER BY birthday;
SELECT * FROM users ORDER BY birthday DESC;
```
```SQL
/* для удобства, используют такую запись */
SELECT username, created_at FROM users
    WHERE birthday < '2018-10-21'
    ORDER BY birthday DESC
    LIMIT 2;
```
### Alter
```SQL
-- в таблице "users"
-- добавить колонку с именем "age" и типом "int"
ALTER TABLE users ADD COLUMN age int;
```
```SQL
ALTER TABLE courses RENAME COLUMN example1 TO example2;
```
```SQL
ALTER TABLE courses DROP COLUMN example2;
```
```SQL
ALTER TABLE addresses
    ADD PRIMARY KEY (id);
```
```SQL
ALTER TABLE addresses
    ALTER COLUMN created_at SET DATA TYPE timestamp,
    ALTER COLUMN street DROP NOT NULL;
```
```SQL
ALTER TABLE products ADD UNIQUE (product_id);
```
### Order
```SQL
SELECT * FROM users ORDER BY username;
```
```SQL
SELECT * FROM users ORDER BY created_at;
```
```SQL
SELECT * FROM users ORDER BY created_at ASC;
SELECT * FROM users ORDER BY created_at DESC;
```
```SQL
SELECT * FROM users ORDER BY first_name, created_at;
```
```SQL
SELECT * FROM users ORDER BY first_name DESC, created_at DESC;
```
```SQL
SELECT first_name, created_at FROM users ORDER BY first_name ASC, created_at DESC;

/* сортируем по возрастанию даты (поле "created_at") */
/* поля, содержащие NULL, идут первыми */
SELECT * FROM users ORDER BY created_at ASC NULLS FIRST; /* и NULLS LAST: */
SELECT * FROM users ORDER BY created_at DESC NULLS LAST;
```
### WHERE
```SQL
SELECT * FROM users WHERE id = 3;
UPDATE users SET first_name = 'Valya' WHERE id = 3;
DELETE FROM users WHERE id = 3;
SELECT * FROM users WHERE id != 3;
SELECT * FROM users WHERE first_name IS NULL;
SELECT * FROM users WHERE created_at IS NOT NULL;
```
```SQL
SELECT *
    FROM users
    WHERE created_at < '2018-10-05';
SELECT *
    FROM users
    WHERE first_name = 'Sunny' OR (created_at > '2018-01-01' AND created_at < '2018-10-05');
SELECT *
    FROM users
    WHERE created_at BETWEEN '2018-01-01' AND '2018-10-05';
```
```SQL
SELECT * FROM users WHERE id = 1 OR id = 2 OR id = 5;
SELECT * FROM users WHERE id IN (1, 2, 5);
SELECT * FROM users WHERE id NOT IN (1, 2, 5);
```
```SQL
SELECT * FROM users WHERE first_name LIKE 'A%';
SELECT * FROM users WHERE email LIKE '%hotmail.com';
/* Если вы хотите искать БЕЗ учёта регистра, то используйте ILIKE. */
```
### Limit
```SQL
SELECT * FROM users LIMIT 10;
SELECT * FROM users ORDER BY id LIMIT 10;
SELECT * FROM users ORDER BY id LIMIT 10 OFFSET 10;
```
```SQL
/* выбрать записи с 21 по 30 */
SELECT * FROM users ORDER BY id LIMIT 10 OFFSET 20;
```
### DISTINCT
```SQL
/* Избавиться от дублей можно с помощью DISTINCT. */
SELECT DISTINCT first_name FROM users;
SELECT DISTINCT first_name, last_name FROM users;
SELECT COUNT(DISTINCT first_name) FROM users;
```
### DISTINCT ON
```SQL
SELECT DISTINCT ON (user_id) * FROM topics;
SELECT DISTINCT ON (user_id) title FROM topics;
```
```SQL
/* равносильные запросы */
SELECT DISTINCT user_id, title FROM topics;
SELECT DISTINCT ON (user_id, title) user_id, title FROM topics;
```
```SQL
SELECT DISTINCT ON (user_id) id, user_id, title, created_at
    FROM topics
    ORDER BY user_id, created_at;
```
### Functions
```SQL
Count
SELECT COUNT(*) FROM users;
SELECT COUNT(*) FROM users WHERE birthday < '2018-10-21';
```
```SQL
Max, Min
SELECT MAX(birthday) FROM users WHERE gender = 'male';
SELECT MIN(birthday) FROM users WHERE gender = 'female';
```
```SQL
Sum
SELECT SUM(amount) FROM orders
    WHERE created_at BETWEEN '2016-01-01' AND '2016-12-31';
```
```SQL
Avg
SELECT AVG(amount) FROM orders
  WHERE created_at BETWEEN '2016-01-01' AND '2016-12-31';
```
### Group
```SQL
SELECT COUNT(*) FROM topics WHERE user_id = 3;
SELECT COUNT(*) FROM topics WHERE user_id = 4;
```
```SQL
SELECT user_id, COUNT(*) FROM topics GROUP BY user_id;
SELECT user_id, COUNT(*) FROM topics GROUP BY user_id ORDER BY count DESC LIMIT 3;
```
```SQL
SELECT user_id, COUNT(*) AS topics_count
    FROM topics
    GROUP BY user_id
    ORDER BY topics_count DESC
    LIMIT 3;
```
```SQL
SELECT first_name AS name FROM users;
SELECT first_name AS name FROM users ORDER BY name;
```
```SQL
SELECT user_id, created_at, COUNT(*) AS topics_count
    FROM topics
    GROUP BY user_id, created_at;
```
```SQL
SELECT user_id, EXTRACT(day from created_at) AS day, COUNT(*) AS topics_count
    FROM topics
    GROUP BY user_id, day
    ORDER BY user_id;
```
```SQL
SELECT user_id, COUNT(*) FROM topics
    GROUP BY user_id
    HAVING COUNT(*) > 1;
```
### Join
```SQL
SELECT first_name, title
    FROM users JOIN topics ON users.id = topics.user_id LIMIT 5;
```
```SQL
SELECT users.id AS user_id, topics.id AS topic_id
    FROM users JOIN topics ON users.id = topics.user_id LIMIT 5;
```
```SQL
SELECT first_name, title FROM users
    LEFT JOIN topics ON users.id = topics.user_id LIMIT 5;
```
```SQL
SELECT COUNT(*)
  FROM users
  LEFT JOIN topics ON users.id = topics.user_id
  WHERE title IS NULL;
```
### Транзакционность
```SQL
BEGIN;
SELECT amount FROM accounts WHERE user_id = 10;
UPDATE accounts SET amount = amount - 50 WHERE user_id = 10;
UPDATE accounts SET amount = amount + 50 WHERE user_id = 30;
COMMIT;
```
```
ACID
Atomicity — Атомарность
Consistency — Согласованность
Isolation — Изолированность
Durability — Устойчивость
```
### EXPLAIN производительность
```SQL
EXPLAIN SELECT * FROM users
  JOIN topics ON users.id = topics.user_id
  WHERE users.created_at > '10.10.2018';

                                       QUERY PLAN
-----------------------------------------------------------------------------------------
 Hash Join  (cost=10.66..23.59 rows=42 width=2377)
   Hash Cond: (topics.user_id = users.id)
   ->  Seq Scan on topics  (cost=0.00..11.30 rows=130 width=572)
   ->  Hash  (cost=10.50..10.50 rows=13 width=1805)
         ->  Seq Scan on users  (cost=0.00..10.50 rows=13 width=1805)
               Filter: (created_at > '2018-10-10 00:00:00'::timestamp without time zone)
(6 rows)
```
Индексы
```SQL
/* Пример создания индекса по полю birthday таблицы users */
CREATE INDEX ON users(birthday);
```
