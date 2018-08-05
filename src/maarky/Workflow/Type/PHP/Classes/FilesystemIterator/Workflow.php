<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\FilesystemIterator;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\DirectoryIterator\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \FilesystemIterator && parent::isValid($value);
    }
}