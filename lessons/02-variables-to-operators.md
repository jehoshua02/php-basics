# PHP Basics Part 2 - Variables to Operators


## Variables

### Basics

Dollar dollar bills yall.
Case sensitive.
Start with letter or underscore (but underscore is a deprecated convention).
$this is a special variable, which can't be assigned.

#### Assign by Value vs Assign By Reference

Default, assign by value.
Assign by reference is another way to do it.
preg_match uses assign by reference to expose match groups while also returning a boolean.
I generally avoid assign by reference, but if you see ampersand prepended to a variable, that's what is going on.

### Scope

Basically, all you need to know, is that the scope of a variable is the function
in which it was defined.

Often times, especially with callbacks (like you see a lot with Laravel Collections),
you want to share a variable from the parent scope. Do this with `use ($myVar)`
syntax on the callback function, right after the arg list.

### Predefined Variables

There are a few superglobal variables defined by php.
If you see a `$_` that's a superglobal.

$_SERVER — Server and execution environment information
$_GET — HTTP GET variables
$_POST — HTTP POST variables
$_FILES — HTTP File Upload variables
$_REQUEST — HTTP Request variables
$_SESSION — Session variables
$_ENV — Environment variables
$_COOKIE — HTTP Cookies

These variables are available in every scope. They are read/write.

Nice to know, but Laravel generally sits between us and them, providing
abstractions that eliminate the need to touch them directly.

Ah, the good ol days.

### Variable Variables

Um. No.
HELL NO.
Just don't (unless you really really really need to, aka probably never).

```
<?php
$myVar = 'banana';
$banana = 'hey monkey';

echo $$myVar; // 'hey monkey';
echo $banana; // 'hey monkey';
```

## Constants

### Syntax

Constants are defined with `define()` function.
Also `const` keyword.

define('SYS_USER_ID', $value);

echo SYS_USER_ID; // <- defined by define()

Constants are available everywhere.
Constants may not be redefined.
Example: SYS_USER_ID

### Magic Constants

There are 9 magical constants provided by PHP.
You know it's a "magic" constant because of the double-undercore prefix and suffix.
They are "magic" because they change based on where they are used.

Example:

```
\Log::debug(__METHOD__, [
    // some data
]);
```

- __LINE__	The current line number of the file.
- __FILE__	The full path and filename of the file with symlinks resolved. If used inside an include, the name of the included file is returned.
- __DIR__	The directory of the file. If used inside an include, the directory of the included file is returned. This is equivalent to dirname(__FILE__). This directory name does not have a trailing slash unless it is the root directory.
- __FUNCTION__	The function name, or {closure} for anonymous functions.
- __CLASS__	The class name. The class name includes the namespace it was declared in (e.g. Foo\Bar). Note that as of PHP 5.4 __CLASS__ works also in traits. When used in a trait method, __CLASS__ is the name of the class the trait is used in.
- __TRAIT__	The trait name. The trait name includes the namespace it was declared in (e.g. Foo\Bar).
- __METHOD__	The class method name.
- __NAMESPACE__	The name of the current namespace.
- ClassName::class

## Expressions

Basically everything in php is an expression?
Cool.

## Operators

There's quite a few operators.
You've probably seen a lot of them.
Others maybe not.

https://www.php.net/manual/en/language.operators.php
