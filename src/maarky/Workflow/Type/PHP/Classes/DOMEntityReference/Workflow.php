<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\DOMEntityReference;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\DOMCharacterData\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \DOMEntityReference && parent::isValid($value);
    }
}