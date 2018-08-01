<?php
declare(strict_types=1);

namespace maarky\Workflow\Task\Arr;

function array_key_exists($key): callable
{
    return function (array $array) use($key): bool {
        return \array_key_exists($key, $array);
    };
}