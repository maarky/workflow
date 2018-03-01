<?php
declare(strict_types=1);

namespace maarky\Workflow\Component;

use maarky\Monad\SingleContainer;
use maarky\Option\Option;

trait BaseNoResult
{
    protected function __construct(){}

    /**
     * @return mixed
     * @throws \TypeError
     */
    public function get()
    {
        throw new \TypeError;
    }

    /**
     * @param mixed $else
     * @return mixed
     * @throws \TypeError
     */
    public function getOrElse($else)
    {
        if(static::isValid($else)) {
            return $else;
        }
        throw new \TypeError();
    }

    /**
     * @param callable $call
     * @return mixed
     * @throws \TypeError
     */
    public function getOrCall(callable $call)
    {
        $result = $call();
        if(static::isValid($result)) {
            return $result;
        }
        throw new \TypeError();
    }

    /**
     * @param SingleContainer $else
     * @return SingleContainer
     */
    public function orElse(SingleContainer $else): SingleContainer
    {
        return $else;
    }

    /**
     * @param callable $call
     * @return SingleContainer
     */
    public function orCall(callable $call): SingleContainer
    {
        return $call();
    }

    /**
     * @return bool
     */
    public function isDefined(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return true;
    }

    /**
     * @param callable $filter
     * @return SingleContainer
     */
    public function filter(callable $filter): SingleContainer
    {
        return $this;
    }

    /**
     * @param callable $filter
     * @return SingleContainer
     */
    public function filterNot(callable $filter): SingleContainer
    {
        return $this;
    }

    /**
     * @param callable $map
     * @return SingleContainer
     */
    public function map(callable $map): SingleContainer
    {
        return $this;
    }

    /**
     * @param callable $map
     * @return SingleContainer Any type of SingleContainer returned by $map
     * @throws \TypeError If $map does not return a SingleContainer
     */
    public function flatMap(callable $map): SingleContainer
    {
        return $this;
    }

    /**
     * @param callable $each
     * @return SingleContainer
     */
    public function foreach(callable $each): SingleContainer
    {
        return $this;
    }

    /**
     * @param callable $nothing
     * @return SingleContainer
     */
    public function fornothing(callable $nothing): SingleContainer
    {
        $nothing($this);
        return $this;
    }

    public function isError(): bool
    {
        return false;
    }

    public function getError(): Option
    {
        return Option::new(null);
    }
}