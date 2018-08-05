<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\IteratorIterator;

abstract class Workflow extends \maarky\Workflow\Type\Object\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \IteratorIterator && parent::isValid($value);
    }
}