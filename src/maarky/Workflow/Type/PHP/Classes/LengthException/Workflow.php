<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\LengthException;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\LogicException\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \LengthException && parent::isValid($value);
    }
}