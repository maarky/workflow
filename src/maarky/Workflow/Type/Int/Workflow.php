<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\Int;

abstract class Workflow extends \maarky\Workflow\Type\Numeric\Workflow
{
    public static function isValid($value): bool
    {
        return is_int($value);
    }
}