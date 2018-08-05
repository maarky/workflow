<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\ReflectionZendExtension;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\ReflectionType\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \ReflectionZendExtension && parent::isValid($value);
    }
}