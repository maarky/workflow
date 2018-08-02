<?php
declare(strict_types=1);

namespace maarky\Workflow\Task\Arr\Filter;

use maarky\Workflow\Task\Utility;

function array_key_exists($key): callable
{
    $callback = function ($array) use($key) {
        return \array_key_exists($key, $array);
    };
    return Utility::doBooleanCallback($callback);
}