<?php
declare(strict_types=1);

namespace maarky\Workflow\Task\Arr\Map;

trait Intersect
{
    public function intersect(...$arrays)
    {
        return function ($array) use($arrays) {
            $callback = function () use($array, $arrays) {
                return array_intersect($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function intersectAssoc(...$arrays)
    {
        return function ($array) use($arrays) {
            $callback = function () use($array, $arrays) {
                return array_intersect_assoc($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function intersectKey(...$arrays)
    {
        return function ($array) use($arrays) {
            $callback = function () use($array, $arrays) {
                return array_intersect_key($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function intersectUassoc($callback, ...$arrays)
    {
        return function ($array) use($callback, $arrays) {
            $arrays[] = $callback;
            $callback = function () use($array, $arrays) {
                return array_intersect_uassoc($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function intersectUkey($callback, ...$arrays)
    {
        return function ($array) use($callback, $arrays) {
            $arrays[] = $callback;
            $callback = function () use($array, $arrays) {
                return array_intersect_ukey($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }
}