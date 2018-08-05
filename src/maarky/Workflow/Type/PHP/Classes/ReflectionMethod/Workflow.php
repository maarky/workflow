<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\ReflectionMethod;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\ReflectionFunctionAbstract\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \ReflectionMethod && parent::isValid($value);
    }
}