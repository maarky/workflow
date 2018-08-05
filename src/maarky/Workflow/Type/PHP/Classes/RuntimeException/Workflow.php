<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\RuntimeException;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\LogicException\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \RuntimeException && parent::isValid($value);
    }
}