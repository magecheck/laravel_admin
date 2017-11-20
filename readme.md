Laravel Admin 5.4.15 with:
==================================================

> Bootstrap 3.3.4

> Font Awesome

> Code supports translation to a different language

> Login by changing factor (username or email) - Configurable

> My Account

> Users

> Groups

> Roles

> Permission over route by user role - Configurable

> Contact Section

> Grabber for google js for pagespeed insights - No more external call on page load (just a cron job that grabbs the file daily)

> Google Analytics code

> Grabber for facebook js for pagespeed insights - No more external call on page load (just a cron job that grabbs the file daily)

> Facebook pixel code

> Config section with system configs and ability to add extra

> Automatic installation of framework with one shell command that takes about ~5 seconds to process


## Installation

Download the code locally either with download or clone.

Download the sample to some directory (it can be your home dir or `/var/www/html`) and run Composer as follows:

```
php composer.phar install
```

The command above will install the dependencies.

Go to root folder and copy the .env file, if you are too lazy to do that you can run the following:

```
php install
```

This will copy the .env.example to a .env file.

Now complete the host details and the db name, you do not need to create that database, yes I did that for you also. 
And run:

```
php install
```

Yes again because the last time you did this for the .env file and I need that info in order to build the database.

Of course you will have to do the Apache configuration also, if you really want me to do that for you I can do it, just ask.

Ok, I won't wait for you to decide on that cause I want you to stay for a few minutes, monitoring you right now. (not me, Google, I wouldn't do that to you, you seem like a nice person)

So let's cut to the chase:

Open Terminal (CTRL + ALT + T) and use your God power

```
sudo su
```

You will figure out what is the next step before this one:

```
nano /etc/hosts
```

Add your website, this one will be 

```
127.0.0.1   laraveladmin.lh
```

To close nano:
```
CTRL + X
```

Now lets add the vhost:
```
cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/001-laraveladmin.conf
nano /etc/apache2/sites-available/001-laraveladmin.conf
```

Add something like this:

```
<VirtualHost *:80>
    ServerName laraveladmin.lh

    ServerAdmin webmaster@localhost
    DocumentRoot /path_to_your_project/your_project_name/public

    ErrorLog ${APACHE_LOG_DIR}/error-laraveladmin.log
    CustomLog ${APACHE_LOG_DIR}/access-laraveladmin.log combined

    <Directory /path_to_your_project/your_project_name>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Then enable the website:

```
a2ensite 001-laraveladmin.conf
```

Now go to the web and you have it!

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

## Contributing

If you found a mistake or a bug, please report it using the [Issues](https://github.com/magecheck/laravel_admin/issues) page. 
Your feedback is highly appreciated.