# PHP Basics Part 7 - PHPUnit and Practice

## PHPUnit

### 1. Installing PHPUnit

Install phpunit in your project via composer:

```
composer require --dev phpunit/phpunit ^8.4
```

### 2. Writing Tests for PHPUnit

Let's start with a most basic example.

```
mkdir tests
touch tests/MyTest.php
```

Inside the test, start with something simple.

```php
<?php
use PHPUnit\Framework\TestCase;

class MyTest extends TestCase
{
    public function testSomething()
    {
        $this->assertTrue(true, 'true is always true');
    }
}
```

Now run it.

```
./vendor/bin/phpunit tests
```

`phpunit` will scan the `tests` folder for any files ending with `Test.php`. In the file it finds a class extending `PHPUnit\Framework\TestCase`. Then it will execute every method that starts with `test`. In the test you arrange, act, and then make assertions with phpunit's built in assertion methods.

#### Test Dependencies

There are annotations that allow one test to depend on the result of another test.
Does that make tests easier to understand or harder?

#### Data Providers

When you have a slew of scenarios to test and the test logic is quite redundant you can boil the test parameters out into a Data Provider.

```php
<?php
use PHPUnit\Framework\TestCase;

class DataTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     */
    public function testAdd($a, $b, $expected)
    {
        $this->assertSame($expected, $a + $b);
    }

    public function additionProvider()
    {
        return [
            [0, 0, 0],
            [0, 1, 1],
            [1, 0, 1],
            [1, 1, 3]
        ];
    }
}
```

You can see the `@dataProvider` annotation specifies what method will provider the arguments for the test.

The specified provider, `additionProvider`, returns an array of arguments for each scenario.

PHPUnit sees this annotation, executes the provider function, iterates over the scenarios, and passes the array items as arguments to the test method.

Refactor this test to use a provider.

```php
<?php
use PHPUnit\Framework\TestCase;

class MultiplyTest extends TestCase
{
    public function testMultiplyFourNine()
    {
        $this->assertSame(36, 4 * 9);
    }

    public function testMultiplyThreeFive()
    {
        $this->assertSame(15, 3 * 5);
    }

    public function testMultiplyEightSeven()
    {
        $this->assertSame(56, 8 * 7);
    }
}
```

One problem with data providers is if they fail, the error message can be rather cryptic and you have to figure out which scenario in the data provider triggered the failure. Refactor your dataProvider to include names.

#### Testing Exceptions

Exception != Bug.

Exceptions are an integral part the method contract. When a method can't do what it says it does, or can't return the type of value it says it will, and such scenarios are not normal (a database query returning `null` is acceptable), throwing an Exception is 100% the right thing to do. We should write tests asserting Exceptions are thrown in these scenarios.

Asserting Exceptions is simple:

```php
$this->expectException(InvalidArgumentException::class);
```

Can you refactor this code and test to throw and expect exceptions instead of returning false?

```php
<?php
use PHPUnit\Framework\TestCase;

class MyExceptionTest extends TestCase
{
    public function testException()
    {
        $instance = new MyClass;
        $this->assertFalse($instance->foo());
    }
}

class MyClass
{
    public function doSomething()
    {
        return false;
    }
}
```

Can you update the test to assert on the Exception message or code?

#### Testing PHP Errors, Warnings, and Notices

In PHP, there are "Errors", "Warnings" and "Notices". These are different from Exceptions.

PHPUnit has methods you can use to expect errors, warnings, or notices. This isn't something we typically do though.

#### Testing Output

Maybe you have a function that outputs something instead of returning it (`echo`, `print`, etc). You can assert on the output with phpunit's `expectOutputString` method.

### 3. The Command-Line Test Runner

The PHPUnit Command-Line Test runner has a lot of options that can be used to configure how phpunit runs your tests.

You can see all the options available by running this command.

```
phpunit --help
```

Some useful ones for every day use:

- `--filter SomeClass`: only run tests whose class name matches `SomeClass`
- `--group CircleExcluded`: only run tests with the `@group CircleExcluded` annotation
- `--exclude-group CircleExcluded`: skip tests with the `@group CircleExcluded` annotation
- `--list-groups`: list all the possible groups
- `--testsuite MyTestSuite`: only run tests in the `MyTestSuite` suite
- `--stop-on-failure`: stop after the first error or failure
- `--repeat 5`: repeate tests 5 times

Take a minute to try some of these out.

### 4. Fixtures

Example:
```php
<?php
use PHPUnit\Framework\TestCase;

class TemplateMethodsTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");
    }

    protected function setUp(): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");
    }

    protected function assertPreConditions(): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");
    }

    public function testOne()
    {
        fwrite(STDOUT, __METHOD__ . "\n");
        $this->assertTrue(true);
    }

    public function testTwo()
    {
        fwrite(STDOUT, __METHOD__ . "\n");
        $this->assertTrue(false);
    }

    protected function assertPostConditions(): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");
    }

    protected function tearDown(): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");
    }

    public static function tearDownAfterClass(): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");
    }

    protected function onNotSuccessfulTest(Throwable $t): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");
        throw $t;
    }
}
```

```
$ phpunit TemplateMethodsTest
PHPUnit 8.4.0 by Sebastian Bergmann and contributors.

TemplateMethodsTest::setUpBeforeClass
TemplateMethodsTest::setUp
TemplateMethodsTest::assertPreConditions
TemplateMethodsTest::testOne
TemplateMethodsTest::assertPostConditions
TemplateMethodsTest::tearDown
.TemplateMethodsTest::setUp
TemplateMethodsTest::assertPreConditions
TemplateMethodsTest::testTwo
TemplateMethodsTest::tearDown
TemplateMethodsTest::onNotSuccessfulTest
FTemplateMethodsTest::tearDownAfterClass

Time: 0 seconds, Memory: 5.25Mb

There was 1 failure:

1) TemplateMethodsTest::testTwo
Failed asserting that <boolean:false> is true.
/home/sb/TemplateMethodsTest.php:30

FAILURES!
Tests: 2, Assertions: 2, Failures: 1.
```

Some notes:

- Don't be wasteful. Only put logic in `setUp` and `tearDown` that are applicable to every test in the file. You can move tests having different requirements into separate files with their own fixtures.
- If you are extending a special test class, you probably need to call the `parent` method.
- Make sure you `tearDown` everything you `setUp`.

### 5. Organizing Tests

Mirroring the file paths makes finding tests way easier.

You can also configure test suites in `phpunit.xml`.

```xml
<phpunit bootstrap="src/autoload.php">
  <testsuites>
    <testsuite name="all">
      <directory>tests</directory>
    </testsuite>
  </testsuites>
</phpunit>
```

See [The XML Configuration File](https://phpunit.readthedocs.io/en/8.4/configuration.html) for more info.

### 6. Risky Tests

There are various options/configurations phpunit supports for identifying "Risky" tests.

Risky tests include:

- Useless Tests: tests that don't test anything (no assertions)
- Unintentionally Covered Code: tests that execute more code than expected
- Output During Test Execution: tests that produce unexpected output
- Test Execution Timeout: tests that take way too damn long
- Global State Manipulation: tests that manipulate global state

See [Risky Tests](https://phpunit.readthedocs.io/en/8.4/risky-tests.html) for more info.

### 7. Incomplete and Skipped Tests

To differentiate incomplete (partially implemented) tests like so:

```php
$this->markTestIncomplete(
    'This test has not been implemented yet.'
);
```

Tests can be skipped as well:

```php
$this->markTestSkipped(
    'The MySQLi extension is not available.'
);
```

### Assertions (at a glance)

There is a huge library of assertion methods provided by phpunit.

Reference this as you write your tests to choose a method for your use case.

https://phpunit.readthedocs.io/en/8.4/assertions.html

## Practice

### Exercism

1. Visit https://exercism.io.
2. Create an account.
3. Join LendioDevs team => https://teams.exercism.io/teams/dxD6AubZcUhpszCzQwrK7ge3/join
4. Follow Exercism instructions to get setup.
5. Join the PHP track.
6. Complete an exercise or two.

### CodeWars
1. Visit https://www.codewars.com.
2. Create an account.
3. Set your clan to `@LendioDevs`
4. Share your profile url with the team.
5. Join the PHP track.
6. Complete a kata or two.
