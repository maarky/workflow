<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\RecursiveTreeIterator;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\RecursiveIteratorIterator\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \RecursiveTreeIterator && parent::isValid($value);
    }
}