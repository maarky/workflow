<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\PDORow;

abstract class Workflow extends \maarky\Workflow\Type\Object\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \PDORow && parent::isValid($value);
    }
}