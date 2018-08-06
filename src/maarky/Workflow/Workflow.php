<?php
declare(strict_types=1);

namespace maarky\Workflow;

use maarky\Monad\SingleContainer;
use maarky\Option\Option;

abstract class Workflow implements SingleContainer
{
    /**
     * @var Workflow
     */
    protected $parent;

    final public static function create($value = null): Workflow
    {
        if(static::isErrorResult($value)) {
            $class = static::getNamespaceResult('Failure');
            return new $class($value);
        }
        $class = static::getNamespaceResult('Success');
        return new $class($value);
    }

    /**
     * @param null $value
     * @return Workflow
     * @deprecated
     */
    final public static function new($value = null): Workflow
    {
        return static::create($value);
    }

    protected static function getNamespaceResult(string $result)
    {
        $namespaceParts = explode('\\', static::class);
        array_pop($namespaceParts);
        return implode('\\', $namespaceParts) . '\\' . $result;
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
        return $value instanceof SingleContainer && get_class($this) === get_class($value);
    }

    public function getParent()
    {
        return \maarky\Workflow\Option\Option::create($this->parent);
    }

    abstract public function isError(): bool;

    abstract public function getError(): Option;
}