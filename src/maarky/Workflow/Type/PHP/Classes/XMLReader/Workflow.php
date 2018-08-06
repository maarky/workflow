<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\XMLReader;

abstract class Workflow extends \maarky\Workflow\Type\Object\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \XMLReader && parent::isValid($value);
    }
}