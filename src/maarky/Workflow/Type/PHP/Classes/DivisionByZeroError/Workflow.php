<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\DivisionByZeroError;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\ArithmeticError\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \DivisionByZeroError && parent::isValid($value);
    }
}