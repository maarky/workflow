<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Interfaces\Reflector;

abstract class Workflow extends \maarky\Workflow\Type\Object\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \Reflector && parent::isValid($value);
    }
}