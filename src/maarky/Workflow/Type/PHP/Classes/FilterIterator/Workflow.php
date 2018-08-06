<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\FilterIterator;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\IteratorIterator\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \FilterIterator && parent::isValid($value);
    }
}