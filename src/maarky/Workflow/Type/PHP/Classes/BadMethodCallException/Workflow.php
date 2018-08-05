<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\BadMethodCallException;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\BadFunctionCallException\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \BadMethodCallException && parent::isValid($value);
    }
}