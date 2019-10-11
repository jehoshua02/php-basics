# PHP Basics Part 6 - Namespaces and Composer

What happens when you have two classes with the same name? Collision.

Namespaces allow two classes to have the same name as long as they are in different namespaces.

## Overview

### PHP Lang Ref

- Defining namespaces
- Declaring sub-namespaces
- Defining multiple namespaces in the same file
- Using namespaces: Basics
- Namespaces and dynamic language features
- namespace keyword and __NAMESPACE__ constant
- Using namespaces: Aliasing/Importing
- Global space
- Using namespaces: fallback to global function/constant
- Name resolution rules
- FAQ: things you need to know about namespaces

### Composer

- Introduction
- Basic usage

## Defining namespaces / Declaring sub-namespaces

Example:

```php
<?php
namespace My\Name; // <- defining a namespace

class MyClass {} // use MyClass with `use My\Name\MyClass;` in another file
```

- Declared using `namespace` keyword at the top of the file
- A lot like folders on a file system (a LOT, usually matches folder names somewhat, but doesn't have to)
- Encapsulates classes, interfaces, traits, functions and constants
- Solves naming collisions between vendors (you, third parties, and php)
- Aliasing with `use` statements avoids needing to reference the fully qualified class name everywhere
- Namespace names are case-insensitive (I think functions and classes are too actually, but use proper casing)
- \ = Root namespace
- PHP is a reserved namespace
- Declaring a sub-namespace is as simple as just adding more slashes and words to the namespace declaration

## Defining multiple namespaces in the same file

You can define multiple namespaces in the same file, but come on, don't do that.

## Using namespaces: Basics

A namespaces element can be referred to in three ways:
- Unqualified name
```php
<?php
namespace My\Example;

$instance = new Whatever(); // resolves to \My\Example\Whatever
```
- Qualified name
```php
<?php
namespace My\Example;

$instance = new Other\Whatever(); // resolves to \My\Example\Other\Whatever
```
- Fully Qualified name
```php
<?php
namespace My\Example;

$instance = new \Some\Other\Whatever(); // fully qualified
```

## Namespaces and dynamic language features

You can reference namespaced items dynamically with strings.

Example:

```php
<?php
namespace My\Example;

class SomeClass
{
    //
}

// with root namespace prefix or without, it's the same
$class = '\My\Example\SomeClass';
$instance = new $class;

$class = 'My\Example\SomeClass';
$instance = new $class;

// slashes need to be escaped when in double quotes
$class = "\\My\\Example\\SomeClass";
$instance = new $class;
```

## namespace keyword and __NAMESPACE__ constant

We've seen this before. It evaluates to the current namespace, as a string.

## Using namespaces: Aliasing/Importing

Example:

```php
<?php
namespace My\Example;

use Some\Cool\Package\Thing; // implies `as Thing`
use Another\Cool\Package\Thing as AnotherThing;

// now they can be referenced unqualified in current namespace
$instance = new Thing;
$another = new AnotherThing;
```

- Import with `use` keyword
- Alias with `as`, class name aliased as is if omitted
- Fully qualified classname, without `\` namespace prefix
- Imports must be at top of file, under namespace

## Global space


No namespace in your code = global = bad.

Use `\` to reference stuff in global namespace without an import (`use` statement).

Example:

```php
<?php
namespace My\Example;

class MyClass
{
    public function doSomething()
    {
        \Log::debug('hello');
        $thing = new \stdClass();
        throw new \Exception('shucks');
    }
}
```

NOTE: Import statements are generally preferred.

## Using namespaces: fallback to global function/constant

We don't define functions and constants outside of classes. So I'm not sure this is that important to cover.

## Name resolution rules

Keep it simple and you won't need to remember these rules.

## FAQ: things you need to know about namespaces

Namespaces are pretty easy to grasp. I think we get it. Let's get to the hands on.

## Composer

What does composer have to do with namespaces?

Autoloading.

You install packages with composer. Those packages have classes, under their own namespace. Your code needs to know how to locate and require these files. This is what autoloading is all about.

PHP doesn't automatically know where to load these classes from. Do you remember `spl_autoload_register`? A function must be registered to teach PHP how to load the classes when they are requested in your code.

Composer generates an autoload script, which registers it's own autoloading function with PHP. Composer generates this script based on the autoload configuration in each packages `composer.json`.

PSR-4 is the standard autoloading strategy, which maps a namespace to a folder, and assumes everything under that namespace lines up with the structure in that folder. With PSR-4, the autoloading files do not need to be regenerated when a new class is added, since the namespace to folder mapping is handled dynamically.

Classmap, or PSR-0, is another autoloading strategy, which scans the folder for all classes, then generates a map pointing fully qualified class names to the file path in which they were found. This was utilized when namespaces were first introduced, to be compatible with legacy code. Now it's primarily used to optimize autoloading. The classmap must be regenerated to pick up new classes.

You configure autoloading for your own classes in your own `composer.json`.

Let's get into it!

### Getting Started

We'll assume you have `composer` installed, but if you didn't you would look at the [Composer Docs](https://getcomposer.org/doc/00-intro.md), or just run your favorite system package installer (like `brew install composer` on mac).

See all Composer commands:

```
composer list
```

Let's create a little project and install phpunit.

```
mkdir phpunit-playground
cd phpunit-playground
composer require phpunit/phpunit
```

Can you configure Composer to load your class? How can you prove it is working?