<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\RegexIterator;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\RecursiveFilterIterator\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \RegexIterator && parent::isValid($value);
    }
}