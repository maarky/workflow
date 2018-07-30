<?php
declare(strict_types=1);

namespace maarky\Workflow\Task;

use maarky\Monad\SingleContainer;
use maarky\Workflow\Workflow;

trait Utility
{
    public function bind(callable $callable, array $args = []): callable
    {
        return function($value) use($callable, $args) {
            if(array_key_exists('?', $args)) {
                $args['?'] = $value;
            } else {
                array_unshift($args, $value);
            }
            $finalArgs = array_values($args);
            return $callable(...$finalArgs);
        };
    }

    public function bindFlatmap(string $class, callable $callable, array $args = []): callable
    {
        return function($value) use($class, $callable, $args): SingleContainer {
            try {
                $callable = $this->bind($callable, $args);
                $result = $callable($value);
            } catch (\Throwable $t) {
                $result = $t;
            }
            return $class::create($result);
        };
    }

    protected function doCallback(callable $callback, callable $isDefined)
    {
        $result = $callback();
        return $isDefined($result) ? $result : null;
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

    protected function doNotnullCallback(callable $callback)
    {
        return $this->doCallback($callback, function ($val) { return !is_null($val); });
    }
}