touch /var/www/username.txt
dmidecode -s bios-release-date >> /var/www/username.txt
#create file to save user flag
touch /var/www/flag.txt
#setup htaccess to make work URL rewrite
#enable rewrite module
a2enmod rewrite
#enable htaccess from config
sed -i -e 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf
#restart apache
systemctl restart apache2
cp /var/www/html/index.html /var/www/index.html
#cut and move all webserver files to web root directory
rm -rf /var/www/html/*
mv /var/www/index.html /var/www/html/index.html
cp -r /root/setup/ITI0103-level-applying-defense/webserver/* /var/www/html/
rm -f /var/www/html/setup.sh
#including hidden files
cp -r /root/setup/ITI0103-level-applying-defense/webserver/.* /var/www/html/
#remove it
rm -rf /root/setup/ITI0103-level-applying-defense/

php /var/www/html/setupdb.php >> /dev/null
#remove loading spinner
rm -f /var/www/html/setup.sh
rm -f /var/www/html/setupdb.php
rm -f /var/www/html/index.html
rm -f /var/www/html/README.md