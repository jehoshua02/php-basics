# Mockery

Mockery is a Test Double library.

## Mocks and Spies

Mockery offers two types of test doubles: mocks and spies.

The main difference between mock and spy objects is what happens when a method is called on the object.

A Mockery mock will error if you try to call a method when there is no expectation
for the method configured on the mock object. Expectations include requirements
for the method name, and may specify number of times the method is expected, what
arguments ought to be passed in, and what the return value ought to be. These
expectations are established on the mock object prior to the action being tested.

A Mockery spy will quietly track all method calls, which can then be utilized to
make assertions after the action being tested.

Mocks are less permissive. For this reason they are recommended. In this lesson,
we will focus on Mocks. If you are curious about spies, see the official Mockery documentation.

## Install

```
composer require mockery/mockery
```

## Integrating with Tests

To use Mockery in a test, you must import.

```php
use Mockery;
```

Because Mockery doesn't automatically hook into PHPUnit, you must tell it when
you want to verify expectations on Mock object in your test `tearDown`.

```php
public function tearDown()
{
    Mockery::close(); // tells Mockery to verify expectations, fail test if not satisfied
    parent::tearDown(); // usually a good idea when overriding tearDown
}
```

## Every Day Use

Creating a mock:

```php
$thing = Mockery::mock(SomeThing::class);
```

Establishing an expectation for a method call, with arguments, at least once, override to return whatever value the test wants:

```php
$thing->shouldReceive('someMethod')->once()->with('foo')->andReturn('bar');
```

Sometimes you want to test a method that calls another method on the same object.
In these cases, a counterintuitive approach is to mock the class being tested,
then tell the mock to leave the method you are testing alone.

```php
$thing->shouldReceive('methodWeWantToMock')->once()->with('someArg')->andReturn('someReturnValue');
$thing->shouldReceive('methodBeingTested')->passthru();
// $thing->methodBeingTested() will hit the real method
// which will then call the methodWeWantToMock
```

Chaining it all together, but still ending with a reference to the mock:

```php
$thing = Mockery::mock(SomeThing::class)
    ->shouldReceive(...)->once()->with(...)->andReturn()
    // ... other expectations ...
    ->getMock();
```

## Testing Static Classes

Mocking static methods can be a real pain. Consider refactoring to Non-Static.

In php, `static` really only means that `$this` can't be referred to inside the method, it also means the method can be called with `::` without instantiating the class. Honestly, these aren't really huge benefits in and of themselves.

In addition, in dependency injecting frameworks, instantiating the class, injecting dependencies through contructor arguments  is a familiar way of doing things. To reference those injected dependencies within the class you would need `$this` anyway.

If you are really married to your static methods, see Mockery documentation for how to mock static methods.

## Practice

Write some tests to verify how Mockery works.

```
./vendor/bin/phpunit lessons/09-mockery/MockeryTest.php
```

## Learn More

This is just a basic introduction to Mockery. I can't recommend their documentation
enough. Even just giving it a skim over to see what's there will boost your productivity
with Mockery.
