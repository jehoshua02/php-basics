# PHP Basics Part 3 - Control Structures to Functions

## Control Structures

We all know if/else if/else

Let's consider loops for a second. Those can be confusing sometimes right?

How many different kinds of loops do we have in PHP? (while, do-while, for, foreach)

### while vs do-while

This is a while loop
```
$shouldLoop = false;
while ($shouldLoop) {
    echo 'do something';
}
```

This is a do-while loop
```
$shouldLoop = false;
do {
    echo 'do something';
} while ($shouldLoop);
```

What is the difference between while and do-while?
Will either of these examples get to `do something`?
When would you use do-while? (when you want it to do something at least once)
When would you want it to do something at least once?
/shrug


### for vs foreach
Here is a `for` loop
```
for (expr1; expr2; expr3) {
    echo 'do something';
}
```

```
for ($i = 0; $i < count($array); $i++) {
    // do something
}
```

Here is a `foreach` loop
```
foreach ($things as $thing) {
    echo 'do something';
}
```

Here is a `foreach` loop with key
```
foreach ($things as $key => $thing) {
    echo 'do something';
}
```

Would you use an array (or anything like an array) with a `for` loop?
When would you use a `for` loop?
What happens to variables declared within the loop, including the key and the value?
How can you avoid loop variables polluting the scope?

### break, continue, return

`break` exits a loop without returning from the function
`continue` aborts the current loop iteration and continues to the next
`return`, exits any loop or control structure, and as we know returns from the function the loop lives in

### switch

Forgetting `break`s is very easy to do
What happens if `break` is missing from a `case`?
Fall through logic might be less obvious

Have you come across a scenario where switch was a better fit than if/else?
Have you come across a scenario where object oriented design patterns were a better fit than both if/else or switch?

```
switch ($something) {
    case 'banana':
        // do something
        break;
    case 'hello':
        // do something
        break;
    default:
        // do something
}
```

## Functions

### User-defined functions

Imagine a world without functions. Just streams of sequential code, everywhere, with no named, callable wrapper around any part of it.
Imagine building a complex application like Pipeline that way.

Functions are awesome huh?

Here's a function
```
function foo($arg_1, $arg_2, /* ..., */ $arg_n) {
    echo "Example function.\n";
    return $retval;
}
```

Starts with the `function` keyword
Then a space
Then the function name
Then no space
Then the arguments list
Then a space
Curly brace
Some fun stuff in the middle
Closing curly brace

Can you define a function inside a function?
What about a class???
Can you overload a function?
Can you redefine a function?

### Function arguments

Remember arguments prefixed with & are passed by reference
You can specify default argument values, making the argument optional
Non-optional arguments must be first in the list
In some slick programming languages you can specify the name of the argument at call time, so argument order isn't important
But not in PHP
You should type hint arguments

Here's an example:

```
function foo(Bar $bar) {
    // ...
}
```

### Returning values

Yep. Functions can return values.
You should type hint return values

Here's an example:

```
function foo(Bar $bar): Baz {
    // ...
}
```

### Variable functions

You can assign a string to a variable
Then call the variable like a function
This will call the function whose name matches the string assigned to the variable

Example
```
function foo() {
    echo "In foo()<br />\n";
}

$func = 'foo';
$func();        // This calls foo()
```

### Internal (built-in) functions

There are loads of internal built-in functions.
https://www.php.net/manual/en/funcref.php

### Anonymous functions

An anonymous function is simply a function without a name.
Since it doesn't have a name, it won't collide with already defined functions.
Anonymous functions can be assigned directly to variables and passed around as values.
You've seen plenty of this when Laravel collections are used.
Anonymous functions can use the `use ()` syntax to inherit variables from existing scope.
