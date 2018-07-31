<?php
declare(strict_types=1);

namespace maarky\Workflow\Task;

use maarky\Workflow\Option\Option;
use maarky\Workflow\Workflow;

class History implements \Iterator
{
    protected $results = [];
    protected $bookmarks = [];
    protected $position;

    public function add(Workflow $result)
    {
        array_unshift($this->results, $result);
        $this->rewind();
        return $this;
    }

    public function bookmark(string $key, Workflow $result)
    {
        $this->bookmarks[$key] = $result;
        return $this;
    }

    public function get(string $key): Option
    {
        if(array_key_exists($key, $this->bookmarks)) {
            $workflow = $this->bookmarks[$key];
        } else {
            $workflow = null;
        }
        return Option::create($workflow);
    }

    public function getLastSuccess(): Option
    {
        $success = null;
        $this->rewind();
        while($this->valid()) {
            if($this->current()->isDefined()) {
                $success = $this->current();
                break;
            }
            $this->next();
        }
        return Option::create($success);
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current(): Workflow
    {
        return $this->results[$this->position];
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->results[$this->position]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->position = 0;
    }
}