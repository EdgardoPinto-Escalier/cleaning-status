# CLEANING STATUS

Cleaning status is a simple web application to manage the cleaning of different hotel rooms. This web application has two different user roles (Administrators and Employees). Developed using PHP as the main language here are some of its features:

- Administrators can create new employee accounts
- Administrators can delete employee accounts
- Administrators can add new rooms
- Administrators can edit or delete rooms
- Administrators can change the room status
- Administrators can update their own user profile details

- Employees can change the room status to clean once they are done with the job
- Employees can can update their own user profile details


## Some of the technologies and tools used to develop this project

- PHP 7.1.22
- phpMyAdmin
- jQuery 3.2.1
- Ajax
- SweetAlert
- Bulma CSS framework
- Font Awesome
- CKEditor 4.7.3


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


## Test accounts

**Administrator test account**


**Username:** `AdminTest`
**Password:** `testpassword`

**Employee test account**


**Username:** `EmployeeTest	`
**Password:** `testpassword`
