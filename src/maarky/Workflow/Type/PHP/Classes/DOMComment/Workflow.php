<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\DOMComment;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\DOMCharacterData\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \DOMComment && parent::isValid($value);
    }
}