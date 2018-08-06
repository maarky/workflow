<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\ErrorException;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\Exception\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \ErrorException && parent::isValid($value);
    }
}