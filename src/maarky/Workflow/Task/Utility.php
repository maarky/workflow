<?php
declare(strict_types=1);

namespace maarky\Workflow\Task;

trait Utility
{
    public function bind(callable $callable, array $args = [])
    {
        $finalCallable = function($value) use($callable, $args) {
            if(array_key_exists('?', $args)) {
                $args['?'] = $value;
            } else {
                array_unshift($args, $value);
            }
            $finalArgs = array_values($args);
            return $callable(...$finalArgs);
        };
        return $finalCallable;
    }

    public function bindFlatmap(string $class, callable $callable, array $args = [])
    {
        $finalCallable = function($value) use($class, $callable, $args) {
            $callable = $this->bind($callable, $args);
            $result = $callable($value);
            $container = $class::new($result);
            return $container;
        };
        return $finalCallable;
    }

    protected function doCallback(callable $callback, callable $isDefined)
    {
        try {
            $result = $callback();
            return $isDefined($result) ? $result : null;
        } catch (\Throwable $t) {
            return $t;
        }
    }

    protected function doArrayCallback(callable $callback)
    {
        return $this->doCallback($callback, 'is_array');
    }

    protected function doIntCallback(callable $callback)
    {
        return $this->doCallback($callback, 'is_int');
    }

    protected function doNumericCallback(callable $callback)
    {
        return $this->doCallback($callback, 'is_numeric');
    }

    protected function doFloatCallback(callable $callback)
    {
        return $this->doCallback($callback, 'is_float');
    }

    protected function doStringCallback(callable $callback)
    {
        return $this->doCallback($callback, 'is_string');
    }

    protected function doTrueCallback(callable $callback)
    {
        return $this->doCallback($callback, function ($val) { return true === $val; });
    }

    protected function doAnyCallback(callable $callback)
    {
        return $this->doCallback($callback, function () { return true; });
    }
}