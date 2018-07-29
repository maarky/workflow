<?php
declare(strict_types=1);

namespace maarky\Workflow\Component;

use maarky\Monad\SingleContainer;
use maarky\Workflow\Workflow;
use maarky\Option\Option;

trait BaseSuccess
{
    protected $value;

    protected function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * @param mixed $else
     * @return mixed
     */
    public function getOrElse($else)
    {
        return $this->get();
    }

    /**
     * @param callable $call
     * @return mixed
     */
    public function getOrCall(callable $call)
    {
        return $this->get();
    }

    /**
     * @param SingleContainer $else
     * @return SingleContainer
     */
    public function orElse(SingleContainer $else): SingleContainer
    {
        return $this;
    }

    /**
     * @param callable $call
     * @return SingleContainer
     */
    public function orCall(callable $call): SingleContainer
    {
        return $this;
    }

    /**
     * @return bool
     */
    public function isDefined(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return false;
    }

    /**
     * @param callable $filter
     * @return SingleContainer
     */
    public function filter(callable $filter): SingleContainer
    {
        try {
            if(true === $filter($this->get())) {
                return $this;
            }
        } catch (\Throwable $t) {
            return static::new($t);
        }
        return static::new();
    }

    /**
     * @param callable $filter
     * @return SingleContainer
     */
    public function filterNot(callable $filter): SingleContainer
    {
        if(false === $filter($this->get())) {
            return $this;
        }
        return static::new();
    }

    /**
     * @param callable $map
     * @return SingleContainer
     */
    public function map(callable $map): SingleContainer
    {
        try {
            $result = $map($this->get());
            if(!static::isValid($result)) {
                return Workflow::new($result);
            }
        } catch (\Throwable $t) {
            $result = $t;
        }

        return static::new($result);
    }

    /**
     * @param callable $flatMap
     * @return SingleContainer Any type of SingleContainer returned by $map
     * @throws \TypeError If $map does not return a SingleContainer
     */
    public function flatMap(callable $flatMap): SingleContainer
    {
        return $flatMap($this->get());
    }

    /**
     * @param callable $each
     * @return SingleContainer
     */
    public function foreach(callable $each): SingleContainer
    {
        $each($this->get());
        return $this;
    }

    /**
     * @param callable $nothing
     * @return SingleContainer
     */
    public function fornothing(callable $nothing): SingleContainer
    {
        return $this;
    }

    /**
     * @param SingleContainer $value
     * @return bool
     */
    public function equals($value): bool
    {
        return parent::equals($value) && $this->get() === $value->get();
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