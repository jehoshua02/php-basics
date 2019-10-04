<?php

class Magic
{
    public function __call(string $name, array $arguments)
    {
        $arguments = join(', ', $arguments);
        return "When you {$name} you begin with {$arguments}.\n";
    }

    public static function __callStatic(string $name, array $arguments)
    {
        return "{$name}, a {$arguments[0]}, a {$arguments[1]} {$arguments[0]}.\n";
    }
}

// __call
$instance = new Magic;
echo $instance->sing('do', 're', 'mi'); // When you sing you begin with do, re, mi.

// __callStatic
echo Magic::do('deer', 'female'); // do, a deer, a female dear.
