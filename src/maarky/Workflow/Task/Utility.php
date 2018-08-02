<?php
declare(strict_types=1);

namespace maarky\Workflow\Task;

use maarky\Monad\SingleContainer;

class Utility
{
    static public function bind(callable $callable, array $args = []): callable
    {
        return function($value) use($callable, $args) {
            if(array_key_exists('?', $args)) {
                $args['?'] = $value;
            } else {
                array_unshift($args, $value);
            }
            return call_user_func_array($callable, $args);
        };
    }

    static public function bindFlatmap(string $class, callable $callable, array $args = []): callable
    {
        return function($value) use($class, $callable, $args): SingleContainer {
            try {
                $callable = static::bind($callable, $args);
                $result = $callable($value);
            } catch (\Throwable $t) {
                $result = $t;
            }
            return $class::create($result);
        };
    }

    static public function doCallback(callable $callback, $input, callable $isDefined)
    {
        $result = $callback($input);
        return $isDefined($result) ? $result : null;
    }

    static public function doArrayCallback(callable $callback): callable
    {
        return function ($input) use($callback) {
            return static::doCallback($callback, $input, 'is_array');
        };
    }

    static public function doIntCallback(callable $callback): callable
    {
        return function ($input) use($callback) {
            return static::doCallback($callback, $input, 'is_int');
        };
    }

    static public function doNumericCallback(callable $callback): callable
    {
        return function ($input) use($callback) {
            return static::doCallback($callback, $input, 'is_numeric');
        };
    }

    static public function doFloatCallback(callable $callback): callable
    {
        return function ($input) use($callback) {
            return static::doCallback($callback, $input, 'is_float');
        };
    }

    static public function doStringCallback(callable $callback): callable
    {
        return function ($input) use($callback) {
            return static::doCallback($callback, $input, 'is_string');
        };
    }

    static public function doTrueCallback(callable $callback): callable
    {
        return function ($input) use($callback) {
            return static::doCallback($callback, $input, function ($val) { return true === $val; });
        };
    }

    static public function doAnyCallback(callable $callback): callable
    {
        return function ($input) use($callback) {
            return static::doCallback($callback, $input, function () { return true; });
        };
    }

    static public function doNotnullCallback(callable $callback): callable
    {
        return function ($input) use($callback) {
            return static::doCallback($callback, $input, function ($val) { return !is_null($val); });
        };
    }

    static public function doBooleanCallback(callable $callback): callable
    {
        return function ($input) use($callback) {
            return static::doCallback($callback, $input, 'is_bool');
        };
    }
}