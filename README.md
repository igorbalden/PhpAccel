# PhpAccel

### Php Api Starter application.

PhpAccel is an Api starter. Just boilerplate code, not a framework.  

### Requirements  
Tested with Php7.4, and Php8.0, on Apache, and Nginx.  
This demo application, as is, uses an Sqlite3 database,  
so Php must load this extension.  

### Sqlite to Mysql
Alternatively, the user may create a new Mysql database,  
and import the **phpacceldb.sql** file in it.  
The **.env** file must be edited, to include the database credentials.  
Last, in **./src/config.php** lines 40-46 must be uncommented,  
and lines 48-50 must be commented out.

### Usage
1.  Clone the repo locally.  
2.  Run **composer install**.  
3.  Copy **.env.keep** to **.env**  
    Edit BASE_URL value.    
4.  Make **./logs/** directory writable by Php.  
    Make **./phpacceldb.sqlite** file writable.  
    For testing, make **./tests/phpacceldb-test.sqlite** file writable.  

```sh
# Start application locally
$ composer start

# Visit http://localhost:8010 with the browser.

# Testing  
$ composer test
```

### Logger  
To use $logger for debugging, enter  
**global $logger**  
**$logger->debug('log this');**  
anywhere in the code.

### User authentication
This demo includes user register and login functionality, and protected Api routes.  
The code has been built to show how the different components work together rather,  
than building a complete user management system.  

More in **/docs**  
