<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\RecursiveFilterIterator;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\FilterIterator\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \RecursiveFilterIterator && parent::isValid($value);
    }
}