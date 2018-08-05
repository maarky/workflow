<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\DOMText;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\DOMCharacterData\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \DOMText && parent::isValid($value);
    }
}