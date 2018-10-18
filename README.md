# CLEANING STATUS
Cleaning status is a simple web application to manage the cleaning of different hotel rooms. This web application has two different user roles (Administrators and Employees).



## How to use it
Please clone the repository to your desktop, upload the files to your server and create a new database, once you have a database import the `webproje_hotel_cleaning.sql` database file into your database.

Finally replace your database credentials inside the init.php on the `$GLOBALS['config']` array:

```php
$GLOBALS['config'] = array(
   'mysql' => array(
		'host' => 'localhost',
		'username' => '< YOUR DATABASE USERNAME GOES HERE >',
		'password' => '< YOUR DATABASE PASSWORD GOES HERE >',
		'db' => '< YOUR DATABASE NAME GOES HERE >'
	),
	'session' => array(
		'session_name' => 'users',
		'tokens_name' =>  'tokens'
	)
);
```

## Demo Site
