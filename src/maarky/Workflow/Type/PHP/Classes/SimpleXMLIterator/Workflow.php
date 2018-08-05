<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\SimpleXMLIterator;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\SimpleXMLElement\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \SimpleXMLIterator && parent::isValid($value);
    }
}