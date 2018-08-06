<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\ReflectionException;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\Exception\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \ReflectionException && parent::isValid($value);
    }
}