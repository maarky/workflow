<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Classes\DOMProcessingInstruction;

abstract class Workflow extends \maarky\Workflow\Type\PHP\Classes\DOMCharacterData\Workflow
{
    public static function isValid($value): bool
    {
        return $value instanceof \DOMProcessingInstruction && parent::isValid($value);
    }
}