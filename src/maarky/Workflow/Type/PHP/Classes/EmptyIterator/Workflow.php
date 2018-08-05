<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\EmptyIterator;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\SplFileInfo\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \EmptyIterator && parent::isValid($value);
    }
}