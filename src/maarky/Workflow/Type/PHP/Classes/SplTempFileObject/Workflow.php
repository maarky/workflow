<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\SplTempFileObject;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\SplFileObject\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \SplTempFileObject && parent::isValid($value);
    }
}