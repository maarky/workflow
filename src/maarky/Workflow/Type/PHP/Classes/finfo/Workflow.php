<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\finfo;

abstract class Workflow extends \maarky\Workflow\Type\Object\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \finfo && parent::isValid($value);
    }
}