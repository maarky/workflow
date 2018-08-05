<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\Generator;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\SplFileInfo\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \Generator && parent::isValid($value);
    }
}