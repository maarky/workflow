<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\RecursiveDirectoryIterator;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\FilesystemIterator\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \RecursiveDirectoryIterator && parent::isValid($value);
    }
}