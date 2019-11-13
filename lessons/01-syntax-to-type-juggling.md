# PHP Basics Part 1 - Syntax to Type Juggling

## Outline

Goal
- Review/Learn PHP Basics

Why?
- Fill in those little gaps in knowledge
- Discern between the language and the frameworks
- Establish common terminology for speaking about PHP
- Ensure a foundation for learning beyond the basics

Language Reference
- Basic syntax
- Types
- Variables
- Constants
- Expressions
- Operators
- Control Structures
- Functions
- Classes and Objects

## Basic Syntax

### PHP Tags

This is an opening php tag.

```
<?php
```

This is a closing php tag.

```
?>
```

Let's look at some old school PHP templating:

```
<p>This is going to be ignored by PHP and displayed by the browser.</p>
<?php echo 'While this is going to be parsed.'; ?>
<p>This will also be ignored by PHP and displayed by the browser.</p>

<?php if ($expression == true): ?>
  This will show if the expression is true.
<?php else: ?>
  Otherwise this will show.
<?php endif; ?>
```

Everything between is interpreted as PHP code.
Everything outside these tags is output as is.
Do not use php closing tag in class files.
You can use php tags in templates, but when in blade, do blade.
Blade templates are compiled down to vanilla php tags.

### Comments

```
<?php
// This is a single-line comment
/*
This is a multi line comment
*/
```

Moving on.

## Types

### Introduction

There are 10 primitive types

Scalar: boolean, integer, float, string

Compound: array, object, callable, iterable

Special: resource, NULL

### Booleans

Style: we use lowercase `true` and `false`

`$something == true` can be simplified to just `$something`

`$something == false` can be simplified to just `!$something`

Type juggling FTW.

Falsy values:

- the boolean FALSE itself
- the integers 0 and -0 (zero)
- the floats 0.0 and -0.0 (zero)
- the empty string, and the string "0"
- an array with zero elements
- the special type NULL (including unset variables)
- SimpleXML objects created from empty tags

Truthy values: everything else.

### Integers

Integers larger than max int size are converted to floats.
Max int size is platform dependent.
Usually 2B for 32 bit.
9E18 for 64 bit.
Unsigned integers not supported.

```
<?php
$a = 1234; // decimal number
$a = 0123; // octal number (equivalent to 83 decimal)
$a = 0x1A; // hexadecimal number (equivalent to 26 decimal)
$a = 0b11111111; // binary number (equivalent to 255 decimal)
?>
```

Weird.
Moving on.

### Floating point numbers

```
<?php
$a = 1.234;
$b = 1.2e3;
$c = 7E-10;
?>
```

Don't trust floats to be precise.
Don't compare floats directly for equality.
It's a long boring story.
We taught metallic rocks how to do math and it's messy.

Here's an neat example of how to compare two floats to 5 digits of precision:

```
<?php
$a = 1.23456789;
$b = 1.23456780;
$epsilon = 0.00001;

if(abs($a-$b) < $epsilon) {
    echo "true";
}
?>
```

Epsilon is "the smallest acceptable difference in calculations", which could
vary per use case.
But use specialized libraries if precision is super critical.

Watch out for `NAN` though.
Do math with numbers.
Don't do math with anything else.

Guess what? `NAN` is truthy! Mwahahahahaha!

Use `is_nan()` to check for `NAN`.

However, `is_nan()` will error if the value isn't a number, or a string number.

### Strings

Did you know?
There are FOUR ways to specify a string in PHP?

- single quoted
- double quoted
- nowdoc syntax (since PHP 5.3.0)
- heredoc syntax

https://www.php.net/manual/en/language.types.string.php

#### Single Quote

By default, use single quote.
To use a single quote in a single quoted string, escape with backslash.
To use a backslash in a single quoted string, escape with backslash.
All other characters will be interpreted as is.
Variables are not expanded in single quoted strings.

#### Double Quote

If you need tabs, newlines, other escape sequences, or variables expanded, use double quoted strings.
Place variables in double quotes with `{$myVar}` syntax.

#### Heredoc

If you
- have a large multi-line string
- don't want to escape quotes
- want variable and escape sequences to be interpreted
Use heredoc.

#### Nowdoc

Like heredocs, nowdocs are multi-line strings.
But like single quoted strings, variables and escape sequences are not interpreted.

#### Variable Parsing

With double quote and heredoc strings, there are two ways to embed variables.
Forget I said that and use the curly brace one. It'll work right every time.

The dot operator can be used to concatenate strings.
Great for simple strings, but for more complex strings, I like double quotes.

#### Functions

There are lots of native php functions for working with strings:

https://www.php.net/manual/en/ref.strings.php
https://www.php.net/manual/en/ref.pcre.php
https://www.php.net/manual/en/ref.url.php

Laravel also provides a Str utility

https://laravel.com/api/5.5/Illuminate/Support/Str.html



### Arrays

Define arrays with square brackets, not the less elegant `array()`.
A list is just a numerically indexed array.
An associative array is a non-numerically indexed array.
For goodness sake ...
Don't mix the two.
Use strings for keys in associative arrays.

### Iterables

This is a new type as of php 7.1.
Use this when you want to type-hint an array or a Traversable.

### Objects

The result of `new` statements.
new stdClass is the closest thing to Javascript's object literal.
Casting values of other types to (object) usually results in a stdClass.
I know, weird right?
Moving on.

### Resources

File handles, database connections, image canvases.
Returned by php functions and stuff.
Not quite basic. Just remember they exist.

### NULL

The only value of type null is the constant null.
It's a value that isn't a value.
The billion dollar mistake.
At least that's what the supposed inventor of null says.

However, I do find some usefulness in the null value.
It says, "I tried to find a value for you, but found nothing."
Whereas `undefined` indicates a slightly different scenario, where the code didn't even try to find a value.
This nuance can be useful when debugging.

### Callbacks / Callables

There are 6 different ways to specify a callable. Let's just look at the docs.

https://www.php.net/manual/en/language.types.callable.php

### Pseudo-types and variables used in this documentation

Types you can't use in code, but will see in documentation:

- mixed
- number
- callback (ie callable)
- array|object
- void (jk, as of 7.1 can use in code)

### Type Juggling

You can explicitly cast a value to a particular type

(boolean)
(integer)
(float)
(string)
(array)
(object)

But the language automatically coerces values to whatever type is needed, so
you'll rarely need to do this.

Also, I'm sparing you lots of details as far as how values are cast from one type
to another. The docs are quite detailed here.

Just be careful to verify your code is doing what you think it is doing.
