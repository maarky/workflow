<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\DOMStringList;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\DOMNode\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \DOMStringList && parent::isValid($value);
    }
}