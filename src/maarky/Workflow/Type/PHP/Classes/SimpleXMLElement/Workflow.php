<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\SimpleXMLElement;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\ReflectionType\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \SimpleXMLElement && parent::isValid($value);
    }
}