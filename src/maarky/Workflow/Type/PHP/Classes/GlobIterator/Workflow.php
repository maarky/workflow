<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\GlobIterator;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\FilesystemIterator\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \GlobIterator && parent::isValid($value);
    }
}