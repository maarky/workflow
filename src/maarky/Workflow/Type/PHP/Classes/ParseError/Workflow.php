<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\ParseError;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\Error\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \ParseError && parent::isValid($value);
    }
}