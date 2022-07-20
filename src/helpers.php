<?php

declare(strict_types=1);

use Illuminate\Container\Container;

if (! function_exists('app')) {
    function app(?string $name = null, array $parameters = [])
    {
        if (is_null($name)) {
            return Container::getInstance();
        }

        return Container::getInstance()->make($name, $parameters);
    }
}

if (! function_exists('resolve')) {
    function resolve(string $name, array $parameters = [])
    {
        return Container::getInstance()->make($name, $parameters);
    }
}
