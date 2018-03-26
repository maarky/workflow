<?php
declare(strict_types=1);

namespace maarky\Workflow\Option;

use maarky\Option\Component\BaseSome;
use maarky\Workflow\Workflow;

class Some extends Option
{
    use BaseSome;

    public function get(): Workflow
    {
        return $this->value;
    }
}
