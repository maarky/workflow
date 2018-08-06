<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\PDOStatement;

abstract class Workflow extends \maarky\Workflow\Type\Object\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \PDOStatement && parent::isValid($value);
    }
}