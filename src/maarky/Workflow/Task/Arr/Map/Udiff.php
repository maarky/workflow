<?php
declare(strict_types=1);

namespace maarky\Workflow\Task\Arr\Map;

trait Udiff
{
    public function udiff(callable $callback, array ...$arrays)
    {
        return function (array $array) use($callback, $arrays) {
            $arrays[] = $callback;
            $callback = function () use($array, $arrays) {
                return array_udiff($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function udiffAssoc(callable $callback, array ...$arrays)
    {
        return function (array $array) use($callback, $arrays) {
            $arrays[] = $callback;
            $callback = function () use($array, $arrays) {
                return array_udiff_assoc($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function udiffUassoc($valCompare, $keyCompare, array ...$arrays)
    {
        return function (array $array) use($valCompare, $keyCompare, $arrays) {
            $arrays[] = $valCompare;
            $arrays[] = $keyCompare;
            $callback = function () use($array, $arrays) {
                return array_udiff_uassoc($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }
}