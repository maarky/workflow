<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\SplHeap;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\SplDoublyLinkedList\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \SplHeap && parent::isValid($value);
    }
}