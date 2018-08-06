<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\DOMNodeList;

abstract class Workflow extends \maarky\Workflow\Type\Object\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \DOMNodeList && parent::isValid($value);
    }
}