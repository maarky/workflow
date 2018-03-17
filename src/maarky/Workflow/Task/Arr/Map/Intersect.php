<?php
declare(strict_types=1);

namespace maarky\Workflow\Task\Arr\Map;

trait Intersect
{
    public function intersect(array ...$arrays)
    {
        return function (array $array) use($arrays) {
            $callback = function () use($array, $arrays) {
                return array_intersect($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function intersectAssoc(array ...$arrays)
    {
        return function (array $array) use($arrays) {
            $callback = function () use($array, $arrays) {
                return array_intersect_assoc($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function intersectKey(array ...$arrays)
    {
        return function (array $array) use($arrays) {
            $callback = function () use($array, $arrays) {
                return array_intersect_key($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function intersectUassoc(callable $callback, array ...$arrays)
    {
        return function (array $array) use($callback, $arrays) {
            $arrays[] = $callback;
            $callback = function () use($array, $arrays) {
                return array_intersect_uassoc($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function intersectUkey(callable $callback, array ...$arrays)
    {
        return function (array $array) use($callback, $arrays) {
            $arrays[] = $callback;
            $callback = function () use($array, $arrays) {
                return array_intersect_ukey($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }
}