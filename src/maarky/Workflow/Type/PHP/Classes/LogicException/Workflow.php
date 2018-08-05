<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\LogicException;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\Exception\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \LogicException && parent::isValid($value);
    }
}