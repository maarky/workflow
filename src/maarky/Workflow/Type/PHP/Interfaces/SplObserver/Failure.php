<?php
declare(strict_types=1);

namespace maarky\Workflow\Type\PHP\Interfaces\SplObserver;

use maarky\Workflow\Component\BaseFailure;

class Failure extends Workflow
{
    use BaseFailure;
}