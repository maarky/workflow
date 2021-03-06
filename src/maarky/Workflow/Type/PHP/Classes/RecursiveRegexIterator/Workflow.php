<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\RecursiveRegexIterator;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\RegexIterator\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \RecursiveRegexIterator && parent::isValid($value);
    }
}