<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\RecursiveCachingIterator;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\CachingIterator\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \RecursiveCachingIterator && parent::isValid($value);
    }
}