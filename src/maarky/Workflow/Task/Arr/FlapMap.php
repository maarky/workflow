<?php
declare(strict_types=1);

namespace maarky\Workflow\Task\Arr;

use maarky\Monad\SingleContainer;
use maarky\Workflow\Type\Numeric\Workflow as NumericWorkflow;
use maarky\Workflow\Workflow;

trait FlapMap
{
    public function product($class = null)
    {
        $class = $class ?: NumericWorkflow::class;
        return function (array $array) use($class) {
            $callback = function() use($array) {
                return array_product($array);
            };
            return $class::new($this->doNumericCallback($callback));
        };
    }

    public function reduce(callable $callable, $initial = null, $class = null)
    {
        $class = $class ?: Workflow::class;
        return function (array $array) use($callable, $initial, $class) {
            $callback = function() use($array, $callable, $initial, $class) {
                return array_reduce($array, $callable, $initial);
            };
            return $class::new($this->doNumericCallback($callback));
        };
    }
}