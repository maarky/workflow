<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\DirectoryIterator;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\SplFileInfo\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \DirectoryIterator && parent::isValid($value);
    }
}