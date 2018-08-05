<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Interfaces\SessionIdInterface;

abstract class Workflow extends \maarky\Workflow\Type\Object\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \SessionIdInterface && parent::isValid($value);
    }
}