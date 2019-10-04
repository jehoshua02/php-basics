# PHP Basics Part 4 - Classes and Objects, The Esoteric

## Foreword

Don't ask when to use any of this. Nobody knows for sure.

But having some idea how it works may be useful ... someday.

## Anonymous classes

PHP 7 adds support for one-off, anonymous classes.

Example:

```
<?php

$util->setLogger(new class {
    public function log($msg)
    {
        echo $msg;
    }
});
```

First stdClass. Now this. PHP wants object literals like Javascript.

## Overloading

Magically handle access to non-accessible properties and methods on a class.

All overloading methods must be defined as public.

No pass by ref arguments.

In other OOP languages, "Overloading" refers multiple methods with same name but different arguments.

#1 reason your IDE doesn't understand certain parts of Laravel.

### Property Overloading

Example:

```php
<?php

class Magic
{
    protected $attrs = [];

    public function __set($name, $value)
    {
        $this->attrs[$name] = $value;
    }

    public function __get($name)
    {
        return $this->attrs[$name];
    }

    public function __isset($name)
    {
        return isset($this->attrs[$name]);
    }

    public function __unset($name)
    {
        unset($this->attrs[$name]);
    }
}

// now you can ...
$instance = new Magic;
$instance->foo = 'bar'; // __set('foo', 'bar')
var_dump(isset($instance->foo)); // true
var_dump($instance->foo); // 'bar'
unset($instance->foo);
var_dump(isset($instance->foo)); // false
var_dump($instance->foo); // NULL with error "PHP Notice: Undefined property: Magic::$foo ..."
```

The example is simple but you can do whatever you want in these magic methods.

Only works on object context. Not static context.

Return value of `__set` is ignored.

### Method Overloading

Example:

```php
<?php

class Magic
{
    public function __call(string $name, array $arguments)
    {
        $arguments = join(',', $arguments);
        return "When you {$name} you begin with {$arguments}.";
    }

    public function __callStatic(string $name, array $arguments)
    {
        return "{$name}, a {$arguments[0]}, a {$arguments[1]} {$arguments[0]}.";
    }
}

// __call
$instance = new Magic;
echo $instance->sing('do', 're', 'mi'); // When you sing you begin with do, re, mi.

// __callStatic
echo Magic::do('deer', 'female'); // do, a deer, a female dear.
```

## Object Iteration

By default you can iterate, using a `foreach` for example, over visible object properties.

Example:

```php
<?php
class MyClass
{
    public $var1 = 'value 1';
    public $var2 = 'value 2';
    public $var3 = 'value 3';

    protected $protected = 'protected var';
    private   $private   = 'private var';

    function iterateVisible() {
       echo "MyClass::iterateVisible:\n";
       foreach ($this as $key => $value) {
           print "$key => $value\n";
       }
    }
}

$class = new MyClass();

foreach($class as $key => $value) {
    print "$key => $value\n";
}
echo "\n";
// foreach outside class only sees public properties
// var1 => value 1
// var2 => value 2
// var3 => value 3

$class->iterateVisible();
// foreach inside the class sees more
// MyClass::iterateVisible:
// var1 => value 1
// var2 => value 2
// var3 => value 3
// protected => protected var
// private => private var
```

A class can override default iteration behavior by implementing one of the built-in `Iterator` or `IteratorAggregate` interfaces.

See also, [generators](https://www.php.net/manual/en/language.generators.php).

## Magic Methods

But wait! There's more!

You've seen `__construct()`, `__destruct()`, `__call()`, `__callStatic()`, `__get()`, `__set()`, `__isset()`, and `__unset()`.

But there's also:

- `__sleep()`: called by `serialize()`
- `__wakeup()`: called by `unserialize()`
- `__toString()`: called when object treated like a string (`echo $instance`, `$instance == 'hello'`)
- `__invoke()`: called when an object is called like a function (`$instance()`)
- `__set_state()`: some blah blah blah about `var_export`. Idk.
- `__clone()`: called when the `clone` keyword is used (`$copy = clone $instance`)
- `__debugInfo()`: called by `var_dump`

Magical means you cannot have methods by these names without the associated "magic" functionality.

You only need to define these methods when you want to customize the behavior of the object with the associated methods.

## Final Keyword

On a method - prevents extending classes from overriding.
On a class - prevents extending altogether.
Only works with classes and methods.

## Object Cloning

Example:

```php
<?php
$clone = clone $instance;
```

By default:
- performs a shallow copy of all the objects properties
- references preserved

Implement `__clone` to customize behavior.

## Comparing Objects

Example:

```php
<?php
var_dump($instance1 == $instance2);
```

With `==`, two objects are equal if:
- same attributes and values (compared with ==)
- of the same class

With `===`, two objects are equal only if they are the same instance of the same class.

## Type Hinting

You know what this is.

Example:

```php
<?php
class Monkey
{
    public function eat(Banana $banana) // <= type hint: $banana must be a Banana
    {
        echo 'Yummy banana';
    }
}
```

## Late Static Bindings

Allows one to reference called class in context of static inheritance.

- `self` and `__CLASS__` refer to the class where they are defined.
- `static` refers to the class that was called (which is late static binding).
- Usually, `static` is what you want.

Example of `self`:

```php
<?php
class A {
    public static function who() {
        echo __CLASS__;
    }
    public static function test() {
        self::who();
    }
}

class B extends A {
    public static function who() {
        echo __CLASS__;
    }
}

B::test(); // A ... bummer.
```

Example of `static`:

```php
<?php
class A {
    public static function who() {
        echo __CLASS__;
    }
    public static function test() {
        static::who(); // Here comes Late Static Bindings
    }
}

class B extends A {
    public static function who() {
        echo __CLASS__;
    }
}

B::test(); // B - yay!
```

## Objects and references

Variables don't hold references to objects. They hold identifiers which point to the object.

Yep. Esoteric.

## Object Serialization

I'm sorry. Too much esoteric for today.

## OOP Changelog

Nope. I've had enough.