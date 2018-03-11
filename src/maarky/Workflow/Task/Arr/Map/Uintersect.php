<?php
declare(strict_types=1);

namespace maarky\Workflow\Task\Arr\Map;

trait Uintersect
{
    public function uintersect($callback, ...$arrays)
    {
        return function ($array) use($callback, $arrays) {
            $arrays[] = $callback;
            $callback = function () use($array, $arrays) {
                return array_uintersect($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function uintersectAssoc($callback, ...$arrays)
    {
        return function ($array) use($callback, $arrays) {
            $arrays[] = $callback;
            $callback = function () use($array, $arrays) {
                return array_uintersect_assoc($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function uintersectUassoc($valCompare, $keyCompare, ...$arrays)
    {
        return function ($array) use($valCompare, $keyCompare, $arrays) {
            $arrays[] = $valCompare;
            $arrays[] = $keyCompare;
            $callback = function () use($array, $arrays) {
                return array_uintersect_uassoc($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }
}