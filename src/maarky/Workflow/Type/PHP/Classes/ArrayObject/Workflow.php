<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\ArrayObject;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\ArrayIterator\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \ArrayObject && parent::isValid($value);
    }
}