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
a=`ifconfig | grep -o "192.168.8.254"`

if [ a != "" ]; then
#this is machine for check
    #this opens in users machine
    echo "Please visit 192.168.8.254" >> /var/www/html/index.html
    echo "<br>I am going to check your work bitch" >> /var/www/html/index.html
else
	#create ssh user ninja:ninja
	#this is web server
	printf 'ninja\nninja\n\n\n\n\n\n\n\n' | adduser --home /var/www/html --shell /bin/bash --no-create-home --ingroup www-data --ingroup ssh ninja
	#remove it
	rm -f iti0103-web-applying-defense.sh
	#vulnerable machine
	cp /var/www/html/index.html /var/www/index.html
	#cut and move all webserver files to web root directory
	rm -rf /var/www/html/*
	mv /var/www/index.html /var/www/html/index.html
	cp -r /root/setup/ITI0103-applying-defense/webserver/* /var/www/html/
	rm -f /var/www/html/setup.sh
	#including hidden files
	cp -r /root/setup/ITI0103-applying-defense/webserver/.* /var/www/html/
	#remove it
	rm -rf /root/setup/ITI0103-applying-defense/

	php /var/www/html/setupdb.php >> /dev/null
	#remove loading spinner
	rm -f /var/www/html/setup.sh
	rm -f /var/www/html/setupdb.php
	rm -f /var/www/html/index.html
	rm -f /var/www/html/README.md
fi