<?php
declare(strict_types=1);

namespace maarky\Workflow\Component;

use maarky\Monad\SingleContainer;
use maarky\Workflow\Workflow;
use maarky\Option\Option;

trait BaseSuccess
{
    /**
     * @var Option 
     */
    protected $value;

    protected function __construct($value)
    {
        $value = static::isValid($value) ? $value : null;
        $this->value = Option::create($value);
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->value->get();
    }

    /**
     * @param mixed $else
     * @return mixed
     */
    public function getOrElse($else)
    {
        return $this->value->getOrElse($else);
    }

    /**
     * @param callable $call
     * @return mixed
     */
    public function getOrCall(callable $call)
    {
        return $this->value->getOrCall($call);
    }

    /**
     * @param SingleContainer $else
     * @return SingleContainer
     */
    public function orElse(SingleContainer $else): SingleContainer
    {
        if($this->isDefined()) {
            return $this;
        }
        return $else;
    }

    /**
     * @param callable $call
     * @return SingleContainer
     */
    public function orCall(callable $call): SingleContainer
    {
        if($this->isDefined()) {
            return $this;
        }
        $else = $call();
        return $else;
    }

    /**
     * @return bool
     */
    public function isDefined(): bool
    {
        return $this->value->isDefined();
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->value->isEmpty();
    }

    /**
     * @param callable $filter
     * @return SingleContainer
     */
    public function filter(callable $filter): SingleContainer
    {
        try {
            if($this->value->filter($filter)->isDefined()) {
                return $this;
            }
            $value = null;
        } catch (\Throwable $t) {
            $value = $t;
        }
        $workflow = static::create($value);
        return $workflow;
    }

    /**
     * @param callable $filter
     * @return SingleContainer
     */
    public function filterNot(callable $filter): SingleContainer
    {
        try {
            if($this->value->filterNot($filter)->isDefined()) {
                return $this;
            }
            $value = null;
        } catch (\Throwable $t) {
            $value = $t;
        }
        $workflow = static::create($value);
        return $workflow;
    }

    /**
     * @param callable $map
     * @return SingleContainer
     */
    public function map(callable $map): SingleContainer
    {
        try {
            $result = $this->value->map($map);
            $result = $result->isDefined() ? $result->get() : null;
        } catch (\Throwable $t) {
            $result = $t;
        }

        $workflow = static::create($result);
        return $workflow;
    }

    /**
     * @param callable $flatMap
     * @return SingleContainer Any type of SingleContainer returned by $map
     * @throws \TypeError If $map does not return a SingleContainer
     */
    public function flatMap(callable $flatMap): SingleContainer
    {
        if($this->isEmpty()) {
            return $this;
        }
        return $this->value->flatMap($flatMap);
    }

    /**
     * @param callable $each
     * @return SingleContainer
     */
    public function foreach(callable $each): SingleContainer
    {
        $this->value->foreach($each);
        return $this;
    }

    /**
     * @param callable $nothing
     * @return SingleContainer
     */
    public function fornothing(callable $nothing): SingleContainer
    {
        $this->value->fornothing($nothing);
        return $this;
    }

    /**
     * @param SingleContainer $value
     * @return bool
     */
    public function equals($value): bool
    {
        if(!parent::equals($value) || $this->isDefined() != $value->isDefined()) {
            return false;
        }
        if($this->isEmpty() && $value->isEmpty()) {
            return true;
        }
        return  $this->value->get() === $value->get();
    }

    public function isError(): bool
    {
        return false;
    }

    public function getError(): Option
    {
        return Option::create(null);
    }
}