# APACHE2
- #### Create localhost configuration
```angular2html
sudo nano /etc/apache2/sites-available/my_domain.conf
sudo ufw allow 80
```
```angular2html
<VirtualHost *:80>

    ServerAdmin webmaster@my_domain.com
    ServerName my_domain.com
    ServerAlias *.my_domain.com

    DocumentRoot "/var/www/my_domain.com/public"

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined

    <Directory "/var/www/my_domain.com/public">

        # Ignore the .htaccess file in this directory
        AllowOverride None

        # Make pretty URLs
        <IfModule mod_rewrite.c>

            <IfModule mod_negotiation.c>
                Options -MultiViews
            </IfModule>

            RewriteEngine On

            # Redirect Trailing Slashes...
            RewriteRule ^(.*)/$ /$1 [L,R=301]

            # Handle Front Controller...
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^ index.php [L]

        </IfModule>
    </Directory>

    Redirect / https://my_domain.com/

</VirtualHost>

<VirtualHost *:443>

    ServerAdmin webmaster@my_domain.com
    ServerName my_domain.com
    ServerAlias *.my_domain.com

    DocumentRoot "/var/www/my_domain.com/public"

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined

    SSLEngine on
    SSLCertificateFile /etc/ssl/certs/server.pem
    SSLCertificateKeyFile   /etc/ssl/private/server.key

    <Directory "/var/www/my_domain.com/public">
        # Ignore the .htaccess file in this directory
        AllowOverride None

        # Make pretty URLs
        <IfModule mod_rewrite.c>
            <IfModule mod_negotiation.c>
                Options -MultiViews
            </IfModule>

        RewriteEngine On

        # Redirect Trailing Slashes...
        RewriteRule ^(.*)/$ /$1 [L,R=301]

        # Handle Front Controller...
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^ index.php [L]

        </IfModule>
    </Directory>
</VirtualHost>

# vim: syntax=apache ts=4 sw=4 sts=4 sr noet
```
- #### Put your Laravel project to /var/www/ and add permissions
```angular2html
cp -r /home/novapc/my_domain/com /var/www/
sudo chown -R www-data:www-data /var/www/my_domain.com
sudo chmod -R 755 /var/www/my_domain.com
```
- #### Enable re_write mod and my_domain.conf
```angular2html
sudo a2ensite my_domain.conf
sudo a2dissite 000-default.conf

sudo a2enmod rewrite

sudo service apache2 restart
```
- #### Check server status 
```angular2html
sudo apache2ctl configtest
```
- #### Reinstall apache2
```angular2html
sudo apt-get remove --purge apache2
sudo apt-get install apache2
```
- #### Restart apache2
```angular2html
sudo systemctl restart apache2
```
***
- **[my_domain.com](http://my_domain.com)**
- #### Add domain to hosts file
```angular2html
sudo nano /etc/hosts

GNU nano 4.8                       /etc/hosts
127.0.0.1       localhost my_domain.com www.my_domain.com
127.0.1.1       novapc-ThinkCentre-M92

# The following lines are desirable for IPv6 capable hosts
::1     ip6-localhost ip6-loopback
fe00::0 ip6-localnet
ff00::0 ip6-mcastprefix
ff02::1 ip6-allnodes
ff02::2 ip6-allrouters
```
***
## SSL - certificate
- #### generate SSL-certificate
```angular2html
openssl req -new -x509 -days 30 -keyout server.key -out server.pem
```
- #### unlock password frome SSL and add permission
```angular2html
cp server.key{,.orig}
openssl rsa -in server.key.orig -out server.key
rm server.key.orig

sudo cp server.pem /etc/ssl/certs/
sudo cp server.key /etc/ssl/private/
sudo chmod 0600 /etc/ssl/private/server.key
```
- #### Creat my_domain.com-ssl.conf
```
sudo nano /etc/apache2/sites-available/my_domain.com-ssl.conf
```
```
<IfModule mod_ssl.c>
    <VirtualHost _default_:443>
        ServerAdmin novapc@ukr.net

        DocumentRoot /var/www/my_domain.com

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

        SSLEngine on
        SSLProtocol all -SSLv2

        SSLCertificateFile      /etc/ssl/certs/server.pem
        SSLCertificateKeyFile   /etc/ssl/private/server.key

        <FilesMatch "\.(cgi|shtml|phtml|php)$">
            SSLOptions +StdEnvVars
        </FilesMatch>
        <Directory /usr/lib/cgi-bin>
            SSLOptions +StdEnvVars
        </Directory>

    </VirtualHost>
</IfModule>
```
```
sudo a2ensite my_domain.com-ssl.conf
```

**[apache2 + https](https://help.ubuntu.ru/wiki/apache_%D0%B8_https)**
**[Enable HTTPS on Apache](https://techexpert.tips/apache/enable-https-apache/)**

[laravel facebook](https://www.positronx.io/laravel-socialite-login-with-facebook-tutorial-with-example/)