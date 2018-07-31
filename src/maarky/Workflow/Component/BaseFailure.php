<?php
declare(strict_types=1);

namespace maarky\Workflow\Component;

use maarky\Monad\SingleContainer;
use maarky\Option\Option;

trait BaseFailure
{
    protected $error;

    protected function __construct($error)
    {
        $this->error = $error;
    }

    public function getError(): Option
    {
        return Option::create($this->error);
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

    /**
     * @return mixed
     */
    public function get()
    {
        throw new \TypeError('Cannot get() from failure.');
    }

    /**
     * @param mixed $else
     * @return mixed
     */
    public function getOrElse($else)
    {
        if(static::isValid($else)) {
            return $else;
        }
        throw new \TypeError('Wrong data type for $else');
    }

    /**
     * @param callable $call
     * @return mixed
     */
    public function getOrCall(callable $call)
    {
        $else = $call();
        return $this->getOrElse($else);
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
        return $this->orElse($call($this));
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
        return !$this->isDefined();
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
}