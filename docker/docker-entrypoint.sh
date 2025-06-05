#!/bin/bash

# Modify database connection settings in library.php
sed -i "s/define( 'DBhostname', 'localhost' )/define( 'DBhostname', '$DBhostname' )/g" /var/www/html/library.php
sed -i "s/define( 'DBhostname', 'db763817850.hosting-data.io' )/define( 'DBhostname', '$DBhostname' )/g" /var/www/html/library.php
sed -i "s/define( 'DBusername', 'root' )/define( 'DBusername', '$DBusername' )/g" /var/www/html/library.php
sed -i "s/define( 'DBusername', 'dbo763817850' )/define( 'DBusername', '$DBusername' )/g" /var/www/html/library.php
sed -i "s/define( 'DBpassword', '' )/define( 'DBpassword', '$DBpassword' )/g" /var/www/html/library.php
sed -i "s/define( 'DBpassword', 'iamtheadmin' )/define( 'DBpassword', '$DBpassword' )/g" /var/www/html/library.php
sed -i "s/define( 'DBdatabase', 'property' )/define( 'DBdatabase', '$DBdatabase' )/g" /var/www/html/library.php
sed -i "s/define( 'DBdatabase', 'db763817850' )/define( 'DBdatabase', '$DBdatabase' )/g" /var/www/html/library.php

# Start Apache
exec apache2-foreground
