<?php
declare(strict_types=1);

namespace maarky\Workflow\Option;

use maarky\Workflow\Workflow;

abstract class Option extends \maarky\Option\Type\Object\Option
{
    public static function validate($value): bool
    {
        return $value instanceof Workflow;
    }
}