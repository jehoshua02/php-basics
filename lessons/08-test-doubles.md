# PHPUnit Test Doubles

## What is a Test Double?

A replacement for a dependency of the subject under test, which is indistinguishable
from the real original dependency in api and type, but without the underlying
behavior of the original dependency.

## When would you use a Test Double?

Whenever the thing you are testing depends on something outside itself.

## PHPUnit Test Doubles

PHPUnit provides three functions for generating Test Doubles:

- createStub($type)
- createMock($type)
- getMockBuilder($type)

## When to use a Stub?

> The practice of replacing an object with a test double that (optionally) returns configured return values is referred to as stubbing. You can use a stub to “replace a real component on which the SUT depends so that the test has a control point for the indirect inputs of the SUT. This allows the test to force the SUT down paths it might not otherwise execute”.

Useful functions:

- method
- returnValue
- returnArgument
- returnSelf
- returnValueMap
- onConsecutiveCalls
- throwException

## When to use a Mock?

> The practice of replacing an object with a test double that verifies expectations, for instance asserting that a method has been called, is referred to as mocking.

Useful functions:
- expects
- method
- with

## When to use Mock Builder?

> As mentioned in the beginning, when the defaults used by the createStub() and createMock() methods to generate the test double do not match your needs then you can use the getMockBuilder($type) method to customize the test double generation using a fluent interface. Here is a list of methods provided by the Mock Builder:
