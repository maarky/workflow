<?php
declare(strict_types=1);

namespace maarky\Workflow;

use maarky\Monad\SingleContainer;
use maarky\Option\Option;

abstract class Workflow implements SingleContainer
{
    final public static function new($value = null): Workflow
    {
        if(static::isErrorResult($value)) {
            $class = static::getNamespaceResult('Failure');
            return new $class($value);
        } elseif (!static::isValid($value)) {
            $class = static::getNamespaceResult('NoResult');
            return new $class;
        }
        $class = static::getNamespaceResult('Success');
        return new $class($value);
    }

    public static function getNamespaceResult(string $result)
    {
        $namespaeParts = explode('\\', static::class);
        array_pop($namespaeParts);
        return implode('\\', $namespaeParts) . '\\' . $result;
    }

    public static function isValid($value): bool
    {
        return !is_null($value) && !static::isErrorResult($value);
    }

    public static function isErrorResult($value): bool
    {
        return $value instanceof \Throwable || $value instanceof Error;
    }

    /**
     * @param SingleContainer $value
     * @return bool
     */
    public function equals($value): bool
    {
        return is_object($value) && get_class($this) === get_class($value);
    }

    abstract public function isError(): bool;

    abstract public function getError(): Option;
}