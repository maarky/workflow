<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\ReflectionObject;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\ReflectionClass\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \ReflectionObject && parent::isValid($value);
    }
}