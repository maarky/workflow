<?php
declare(strict_types=1);

namespace maarky\Workflow\Task\Arr\Map;

trait Misc
{
    /**
     * @param int $case CASE_LOWER or CASE_UPPER
     * @return callable For use with Workflow::map()
     */
    public function changeKeyCase(int $case = CASE_LOWER): callable
    {
        /**
         * @param array $array
         * @return array|\Throwable
         */
        return function (array $array) use($case) {
            $callback = function () use($array, $case) {
                return array_change_key_case($array, $case);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function chunk(int $size, bool $preserve_keys = false)
    {
        return function (array $array) use($size, $preserve_keys) {
            $callback = function () use($array, $size, $preserve_keys) {
                return array_chunk($array, $size, $preserve_keys);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function column($columnKey, $indexKey = null)
    {
        return function (array $array) use($columnKey, $indexKey) {
            $callback = function () use ($array, $columnKey, $indexKey) {
                return array_column($array, $columnKey, $indexKey);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function countValues()
    {
        return function (array $array) {
            $callback = function() use($array) {
                return array_count_values ($array);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function fillKeys($value)
    {
        return function (array $array) use($value) {
            $callback = function() use($array, $value) {
                return array_fill_keys($array, $value);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function filter(callable $filter, int $flag = 0)
    {
        return function (array $array) use($filter, $flag) {
            $callback = function() use($array, $filter, $flag) {
                return array_filter($array, $filter, $flag);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function flip()
    {
        return function (array $array) {
            $callback = function() use($array) {
                return array_flip($array);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function keys($search = null, bool $strict = false)
    {
        return function (array $array) use($search, $strict) {
            $callback = function() use($array, $search, $strict) {
                return $search ? array_keys($array, $search, $strict) : array_keys($array);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function map(callable $callback, array ...$arrays)
    {
        return function (array $array) use($callback, $arrays) {
            $callback = function() use($array, $callback, $arrays) {
                return array_map($callback, $array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function mergeRecursive(array ...$arrays)
    {
        return function (array $array) use($arrays) {
            $callback = function() use($array, $arrays) {
                return array_merge_recursive($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function merge(array ...$arrays)
    {
        return function (array $array) use($arrays) {
            $callback = function() use($array, $arrays) {
                return array_merge($array, ...$arrays);
            };
            return $this->doArrayCallback($callback);
        };
    }

    public function pad(int $size, $value)
    {
        return function (array $array) use($size, $value) {
            $callback = function() use($array, $size, $value) {
                return array_pad($array, $size, $value);
            };
            return $this->doArrayCallback($callback);
        };
    }

    /**
     * Get first element from array
     */
    public function head()
    {
        return function (array $array) {
            $callback = function() use($array) {
                return array_shift($array);
            };
            return $this->doAnyCallback($callback);
        };
    }

    /**
     * Get array with first item removed
     */
    public function tail()
    {
        return function (array $array) {
            $callback = function() use($array) {
                return array_slice($array, 1, null, true);
            };
            return $this->doAnyCallback($callback);
        };
    }

    /**
     * Get last element from array
     */
    public function last()
    {
        return function (array $array) {
            $callback = function() use($array) {
                return array_pop($array);
            };
            return $this->doAnyCallback($callback);
        };
    }

    /**
     * Get array with last item removed
     */
    public function init()
    {
        return function (array $array) {
            $callback = function() use($array) {
                return array_slice($array, 0, -1, true);
            };
            return $this->doAnyCallback($callback);
        };
    }
}