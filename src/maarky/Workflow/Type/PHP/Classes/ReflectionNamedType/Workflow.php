<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\ReflectionNamedType;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\ReflectionType\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \ReflectionNamedType && parent::isValid($value);
    }
}