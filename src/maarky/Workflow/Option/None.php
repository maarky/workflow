<?php
declare(strict_types=1);

namespace maarky\Workflow\Option;

use maarky\Option\Component\BaseNone;
use maarky\Workflow\Workflow;

class None extends Option
{
    use BaseNone;

    public function get(): Workflow
    {
        return $this;
    }

    public function getOrElse($else): Workflow
    {
        return $else;
    }

    public function getOrCall(callable $call): Workflow
    {
        return $call();
    }
}