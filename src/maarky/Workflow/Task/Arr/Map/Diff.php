<?php
declare(strict_types=1);

namespace maarky\Workflow\Task\Arr\Map;

trait Diff
{
    public function diff(...$arrays)
    {
        return function ($array) use($arrays) {
            $callback = function () use($array, $arrays) {
                return array_diff($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function diffAssoc(...$arrays)
    {
        return function ($array) use($arrays) {
            $callback = function () use($array, $arrays) {
                return array_diff_assoc($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function diffKey(...$arrays)
    {
        return function ($array) use($arrays) {
            $callback = function () use($array, $arrays) {
                return array_diff_key($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function diffUassoc($callback, ...$arrays)
    {
        return function ($array) use($callback, $arrays) {
            $arrays[] = $callback;
            $callback = function () use($array, $arrays) {
                return array_diff_uassoc($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function diffUkey($callback, ...$arrays)
    {
        return function ($array) use($callback, $arrays) {
            $arrays[] = $callback;
            $callback = function () use($array, $arrays) {
                return array_diff_ukey($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }
}