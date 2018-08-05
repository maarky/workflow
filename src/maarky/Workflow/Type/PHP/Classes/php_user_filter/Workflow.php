<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\php_user_filter;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\SplHeap\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \php_user_filter && parent::isValid($value);
    }
}