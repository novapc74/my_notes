### Установка Apache
```
sudo apt update
sudo apt install apache2
```
### Настройка брандмауэра
список профилей:
```
sudo ufw app list
```
Apache: этот профиль открывает только порт 80 (нормальный веб-трафик без шифрования)
Apache Full: этот профиль открывает порт 80 (нормальный веб-трафик без шифрования) и порт 443 (трафик с шифрованием TLS/SSL)
Apache Secure: этот профиль открывает только порт 443 (трафик с шифрованием TLS/SSL)
```
sudo ufw allow 'Apache'
sudo ufw status
```
### Проверка веб-сервера
Статус службы Apache:
```
sudo systemctl status apache2
hostname -I
```
Публичный адрес:
```
curl -4 icanhazip.com
```
### Управление процессом Apache
Запустить / Остановить / Перезапустить / Перезапустить без отключения соединений -- службу Apache:
```
sudo systemctl start apache2
sudo systemctl stop apache2
sudo systemctl restart apache2
sudo systemctl reload apache2
```
Отключить / Включить загрузку сервера по умолчанию:
```
sudo systemctl disable apache2
sudo systemctl enable apache2
```
### Настройка виртуальных хостов
Создайте директорию для your_domain:
```
sudo mkdir /var/www/your_domain
sudo chown -R $USER:$USER /var/www/your_domain
sudo chmod -R 755 /var/www/your_domain
```
Затем создайте в качестве примера страницу index.html, используя nano или свой любимый редактор:
```
sudo nano /var/www/your_domain/index.html
```
Добавьте в страницу следующий образец кода HTML:
/var/www/your_domain/index.html
```html
<html>
    <head>
        <title>Welcome to Your_domain!</title>
    </head>
    <body>
        <h1>Success!  The your_domain virtual host is working!</h1>
    </body>
</html>
```
Для обслуживания этого контента Apache необходимо создать файл виртуального хоста с правильными директивами. Вместо изменения файла конфигурации по умолчанию, расположенного в /etc/apache2/sites-available/000-default.conf, мы создадим новый файл в /etc/apache2/sites-available/your_domain.conf:
```
sudo nano /etc/apache2/sites-available/your_domain.conf
```
Введите следующий блок конфигурации, который похож на заданный по умолчанию, но обновлен с учетом новой директории и доменного имени:
/etc/apache2/sites-available/your_domain.conf
```
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    ServerName your_domain
    ServerAlias www.your_domain
    DocumentRoot /var/www/your_domain
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```
Активируем файл с помощью инструмента a2ensite:
```
sudo a2ensite your_domain.conf
```
Отключите сайт по умолчанию, определеный в 000-default.conf:
```
sudo a2dissite 000-default.conf
```
Затем проверим ошибки конфигурации:
```
sudo apache2ctl configtest

// Output
// Syntax OK

sudo systemctl restart apache2
```
Теперь Apache должен обслуживать ваше доменное имя. Вы можете проверить это, открыв в браузере адрес http://example.com
### Важные файлы и директории Apache
Контент
```
    /var/www/html: веб-контент, в состав которого по умолчанию входит только показанная ранее страница Apache по умолчанию, выводится из каталога /var/www/html. Это можно изменить путем изменения файлов конфигурации Apache.
```
Конфигурация сервера
```
    /etc/apache2: каталог конфигурации Apache. Здесь хранятся все файлы конфигурации Apache.
    /etc/apache2/apache2conf: главный файл конфигурации Apache. Его можно изменить для внесения изменений в глобальную конфигурацию Apache. Этот файл отвечает за загрузку многих других файлов в каталоге конфигурации.
    /etc/apache2/ports.conf: этот файл задает порты, которые будет прослушивать Apache. По умолчанию Apache прослушивает порта 80, а если активирован модуль с функциями SSL, он также прослушивает порт 443.
    /etc/apache2/sites-available/: каталог, где можно хранить виртуальные хосты для каждого сайта. Apache не будет использовать файлы конфигурации из этого каталога, если они не будут связаны с каталогом sites-enabled. Обычно все изменения конфигурации серверных блоков выполняются в этом каталоге, а затем активируются посредством ссылки на другой каталог с помощью команды a2ensite.
    /etc/apache2/sites-enabled/: каталог, где хранятся активные виртуальные хосты для каждого сайта. Обычно они создаются посредством создания ссылок на файлы конфигурации из каталога sites-available с помощью команды a2ensite. Apache считывает файлы конфигурации и ссылки из этого каталога при запуске или перезагрузке, когда компилируется полная конфигурация.
    /etc/apache2/conf-available/, /etc/apache2/conf-enabled/: эти каталоги имеют те же отношения, что и каталоги sites-available и sites-enabled, но используются для хранения фрагментов конфигурации, которые не принадлежат виртуальному хосту. Файлы из каталога conf-available можно активировать с помощью команды a2enconf и отключить с помощью команды a2disconf.
    /etc/apache2/mods-available/, /etc/apache2/mods-enabled/: эти каталоги содержат доступны и активированные модули соответственно. Файлы с расширением .load содержат фрагменты для загрузки определенных модулей, а файлы с расширением .conf содержат конфигурации этих модулей. Модули можно активировать и отключать с помощью команд a2enmod и a2dismod.
```
Журналы сервера
```
    /var/log/apache2/access.log: по умолчанию каждый запрос веб-сервера регистрируется в этом файле журналда, если Apache не настроен по другому.
    /var/log/apache2/error.log: по умолчанию все ошибки регистрируются в этом файле. Директива LogLevel в конфигурации Apache указывает, насколько детальные записи регистрируются в журналах ошибок.

```
