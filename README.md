[![Latest Stable Version](https://poser.pugx.org/mouf/classname-mapper/v/stable)](https://packagist.org/packages/mouf/classname-mapper)
[![Total Downloads](https://poser.pugx.org/mouf/classname-mapper/downloads)](https://packagist.org/packages/mouf/classname-mapper)
[![Latest Unstable Version](https://poser.pugx.org/mouf/classname-mapper/v/unstable)](https://packagist.org/packages/mouf/classname-mapper)
[![License](https://poser.pugx.org/mouf/classname-mapper/license)](https://packagist.org/packages/mouf/classname-mapper)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/thecodingmachine/classname-mapper/badges/quality-score.png?b=1.0)](https://scrutinizer-ci.com/g/thecodingmachine/classname-mapper/?branch=1.0)
[![Build Status](https://travis-ci.org/thecodingmachine/classname-mapper.svg?branch=1.0)](https://travis-ci.org/thecodingmachine/classname-mapper)
[![Coverage Status](https://coveralls.io/repos/thecodingmachine/classname-mapper/badge.svg?branch=1.0&service=github)](https://coveralls.io/github/thecodingmachine/classname-mapper?branch=1.0)


ClassName mapper
================

What is it?
-----------

Some packages generate PHP classes. When a package generates a class, it needs to know in which directory to put the PHP 
file, so that the class can be autoloaded by the autoloader. 
This package is here to help you find in which directory to write your PHP file.

This package contains a simple `ClassNameMapper` PHP class.

This class will map a fully qualified class name (FQCN) to one or many possible file names according to PSR-0 or PSR-4 rules defined in your `composer.json` file.

So you pass the `ClassNameMapper` a FQCN, and it gives you back a list of file paths that will be checked by the Composer autoloader.

This is very useful in case you want to generate PHP classes, and you don't know where to write those classes.

Sample
------

Imagine your `composer.json` looks like this:

```json
{
    "require" : {
        "mouf/classname-mapper": "~1.0"
    },
    "autoload" : {
        "psr-4" : {
            "Acme\\" : "src/"
        }
    }
}
```

Now, let's say you want to create a `Acme\Controller\MyController` class. Where should you put the class?
To a PHP developer, it is obvious the class will go in `src/Controller/MyController.php`.
To a PHP program, it is a tricky problem. The `ClassNameMapper` is here to solve the problem:

```php
use Mouf\Composer\ClassNameMapper;

// This will create a mapper from your root composer file.
$mapper = ClassNameMapper::createFromComposerFile();

$files = $mapper->getPossibleFileNames('Acme\Controller\MyController');
// $files == ["src/Controller/MyController.php"];
```

You can also query the `ClassNameMapper` for a list of all namespaces that are configured in your `composer.json` file:
 
```php
$namespaces = $mapper->getManagedNamespaces();
// $namespaces == ["Acme\\"];
```
