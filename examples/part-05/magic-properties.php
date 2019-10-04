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
