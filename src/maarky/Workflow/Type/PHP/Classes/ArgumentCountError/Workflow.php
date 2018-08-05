<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\ArgumentCountError;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\TypeError\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \ArgumentCountError && parent::isValid($value);
    }
}