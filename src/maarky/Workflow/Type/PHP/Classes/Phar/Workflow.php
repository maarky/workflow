<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\Phar;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\RecursiveDirectoryIterator\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \Phar && parent::isValid($value);
    }
}