<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\SplStack;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\SplDoublyLinkedList\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \SplStack && parent::isValid($value);
    }
}