# PhpAccel   
![counter-1](https://github.com/igorbalden/phpaccel/raw/master/docs/images/counter-1.jpg "PhpAccel")  

[**PhpAccel**](https://github.com/igorbalden/phpaccel.git) is a Php starter application to accelerate Api development.

Often, Php frameworks are simply too much, when it comes to Api coding. 
Today's frameworks tend to dictate all aspects of development, 
from local environment, to the smallest helper library.

[**PhpAccel**](https://github.com/igorbalden/phpaccel.git) tries to be unobtrusive to the developer.
It has been built to speed up development.
The acceleration claimed is meant to be in development time.
It has not been built with performance in mind, although it is very fast, 
because of its small size, and caching utilised.

## Libraries

The router is the [**Php League router**](https://route.thephpleague.com/5.x)  
The service locator is the [**Php-DI**](https://php-di.org)  
The http message handler is [**Laminas Diactoros**](https://docs.laminas.dev/laminas-diactoros)  
The logger is [**Monolog**](https://github.com/Seldaek/monolog) logger  
From the Doctrine project are utilised 
[**Annotations**](https://www.doctrine-project.org/projects/annotations.html),   
and the [**Abstraction Layer**](https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/index.html)  
The template system is [**Twig**](https://twig.symfony.com/doc/3.x)  
The [**PhpDotEnv**](https://github.com/vlucas/phpdotenv) is also used  
For static analysis is used [**PhpStan**](https://phpstan.org),  
and for unit testing [**PhpUnit**](https://phpunit.de)  


## Authentication in Middleware

Authentication, authorization, and validation are coded in middleware.  
There is no real validation in the demo. The user can choose to use any available validation library, or apply his own validation rules.

A simple register - login system is built with very little frontend - javascript code, so it is easy to be modified, or replaced all together.  
Authentication is done using regular Php session at the backend.

There is only one demo Url to output json response. It's "/api/show/Validation".  
The "validation" middleware on this route exhibits, how to use named parameters from router, in middleware.  
This Url is protected, not public.  
It is the default route for the authorized user. So the user is taken in this route - json response -, after authentication.  
  

![di-3](https://github.com/igorbalden/phpaccel/raw/master/docs/images/di-3.jpg "Dependency Injection")  

## Dependency Injection variations

In this demo I often create objects in the constructor, using the container directly, like :  
```
public function __construct() {
  global $container;
  $this->screener = $container->get('screener');
}
```

Of course it can also be done by
```
public function __construct(Container $container) {
  $this->screener = $container->get('screener');
}
```
or
```
public function __construct(\Twig\Environment $screener) {
  $this->screener = $screener;
}
```
This last option will also need the addition 
of Twig\Environment resolver in service locator, by adding
```
\Twig\Environment::class => \DI\get('screener'),
```
as an element in config.php array.  

It's only a matter of taste which of the 3 options will be used each time. I think the first option is more elegant, but in practice they are equivalent.  

Php-DI documentation is quite detailed, and describes more options for object creation.

## Database server

In project's _Readme_.md file it is described, how the database can be switched from _Sqlite_ to _MySql_.  
In a similar way, it can be switched to any other database system.

