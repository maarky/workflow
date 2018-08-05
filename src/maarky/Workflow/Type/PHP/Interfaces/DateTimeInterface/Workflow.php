<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Interfaces\DateTimeInterface;

abstract class Workflow extends \maarky\Workflow\Type\Object\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \DateTimeInterface && parent::isValid($value);
    }
}