<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\DOMDomError;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\DOMNode\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \DOMDomError && parent::isValid($value);
    }
}