<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\ReflectionFunction;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\ReflectionFunctionAbstract\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \ReflectionFunction && parent::isValid($value);
    }
}