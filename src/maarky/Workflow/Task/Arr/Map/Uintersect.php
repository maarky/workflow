<?php
declare(strict_types=1);

namespace maarky\Workflow\Task\Arr\Map;

trait Uintersect
{
    public function uintersect(callable $callback, array ...$arrays)
    {
        return function (array $array) use($callback, $arrays) {
            $arrays[] = $callback;
            $callback = function () use($array, $arrays) {
                return array_uintersect($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function uintersectAssoc(callable $callback, array ...$arrays)
    {
        return function (array $array) use($callback, $arrays) {
            $arrays[] = $callback;
            $callback = function () use($array, $arrays) {
                return array_uintersect_assoc($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function uintersectUassoc($valCompare, $keyCompare, array ...$arrays)
    {
        return function (array $array) use($valCompare, $keyCompare, $arrays) {
            $arrays[] = $valCompare;
            $arrays[] = $keyCompare;
            $callback = function () use($array, $arrays) {
                return array_uintersect_uassoc($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }
}