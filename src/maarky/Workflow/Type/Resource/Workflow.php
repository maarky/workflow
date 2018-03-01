<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\Resource;

abstract class Workflow extends \maarky\Workflow\Workflow
{
    public static function isValid($value): bool
    {
        return is_resource($value);
    }
}