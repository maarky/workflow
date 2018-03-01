<?php
declare(strict_types=1);

namespace maarky\Workflow\Component;

use maarky\Monad\SingleContainer;
use maarky\Option\Option;

trait BaseFailure
{
    use BaseNoResult;

    protected $error;

    protected function __construct($error)
    {
        $this->error = $error;
    }

    public function getError(): Option
    {
        return Option::new($this->error);
    }

    /**
     * @param SingleContainer $value
     * @return bool
     */
    public function equals($value): bool
    {
        return parent::equals($value) &&
               $this->getError()->getOrElse(true) === $value->getError()->getOrElse(false);
    }

    public function isError(): bool
    {
        return true;
    }
}