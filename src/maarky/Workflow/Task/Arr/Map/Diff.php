<?php
declare(strict_types=1);

namespace maarky\Workflow\Task\Arr\Map;

trait Diff
{
    public function diff(array ...$arrays)
    {
        return function (array $array) use($arrays) {
            $callback = function () use($array, $arrays) {
                return array_diff($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function diffAssoc(array ...$arrays)
    {
        return function (array $array) use($arrays) {
            $callback = function () use($array, $arrays) {
                return array_diff_assoc($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function diffKey(array ...$arrays)
    {
        return function (array $array) use($arrays) {
            $callback = function () use($array, $arrays) {
                return array_diff_key($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function diffUassoc(callable $callback, array ...$arrays)
    {
        return function (array $array) use($callback, $arrays) {
            $arrays[] = $callback;
            $callback = function () use($array, $arrays) {
                return array_diff_uassoc($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function diffUkey(callable $callback, array ...$arrays)
    {
        return function (array $array) use($callback, $arrays) {
            $arrays[] = $callback;
            $callback = function () use($array, $arrays) {
                return array_diff_ukey($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }
}