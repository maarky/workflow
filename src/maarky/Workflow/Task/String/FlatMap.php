<?php
declare(strict_types=1);

namespace maarky\Workflow\Task\String\FlatMap;

use maarky\Workflow\Type\Arr\Workflow as ArrWorkflow;

function str_getcsv(string $delimiter = ',', string $enclosure = '"', string $escape = '\\', string $class = null)
{
    $class = $class ?: ArrWorkflow::class;
    return function ($string) use($delimiter, $enclosure, $escape, $class) {
        $array = \str_getcsv($string, $delimiter, $enclosure, $escape);
        return $class::create($array);
    };
}

function str_split(int $length = 1, string $class = null)
{
    $class = $class ?: ArrWorkflow::class;
    return function ($string) use($length, $class) {
        $array = \str_split($string, $length);
        return $class::create($array);
    };
}