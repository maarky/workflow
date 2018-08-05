<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\RecursiveArrayIterator;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\ArrayIterator\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \RecursiveArrayIterator && parent::isValid($value);
    }
}