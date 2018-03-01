<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\Object;

abstract class Workflow extends \maarky\Workflow\Workflow
{
    public static function isValid($value): bool
    {
        return is_object($value) && 'Closure' !== get_class($value) && !static::isErrorResult($value);
    }
}