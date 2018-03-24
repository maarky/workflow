<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\Float;

abstract class Workflow extends \maarky\Workflow\Type\Numeric\Workflow
{
    public static function isValid($value): bool
    {
        return is_float($value);
    }
}