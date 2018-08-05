<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\PharData;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\RecursiveDirectoryIterator\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \PharData && parent::isValid($value);
    }
}