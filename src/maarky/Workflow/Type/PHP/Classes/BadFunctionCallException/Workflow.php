<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\BadFunctionCallException;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\LogicException\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \BadFunctionCallException && parent::isValid($value);
    }
}