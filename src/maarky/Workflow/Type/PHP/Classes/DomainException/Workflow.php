<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\DomainException;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\BadFunctionCallException\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \DomainException && parent::isValid($value);
    }
}