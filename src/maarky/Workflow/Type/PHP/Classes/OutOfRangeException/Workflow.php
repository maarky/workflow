<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\OutOfRangeException;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\LogicException\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \OutOfRangeException && parent::isValid($value);
    }
}