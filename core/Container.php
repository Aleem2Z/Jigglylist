<?php

namespace Core;

class Container
{
    protected $bindings = [];

    public function bind($key, $resolver)
    {
        $this->bindings[$key] = $resolver;
    }

    public function resolve($key)
    {
        if (array_key_exists($key, $this->bindings)) {
            return call_user_func($this->bindings[$key]);
        }
        throw new \Exception("No matching binding found for {$key}");
    }
}
