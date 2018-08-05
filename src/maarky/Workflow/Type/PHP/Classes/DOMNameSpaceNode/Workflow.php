<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\DOMNameSpaceNode;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\DOMNode\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \DOMNameSpaceNode && parent::isValid($value);
    }
}