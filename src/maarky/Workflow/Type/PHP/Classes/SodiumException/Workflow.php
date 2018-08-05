<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\SodiumException;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\RuntimeException\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \SodiumException && parent::isValid($value);
    }
}