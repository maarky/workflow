<?php
declare(strict_types=1);

namespace maarky\Workflow\Task\Arr;


trait Filter
{
    public function keyExists($key)
    {
        return function (array $array) use($key) {
            $callback = function() use($array, $key) {
                return array_key_exists($key, $array);
            };
            return $this->doTrueCallback($callback);
        };
    }
}