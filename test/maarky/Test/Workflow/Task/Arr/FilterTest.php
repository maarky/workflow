<?php
declare(strict_types=1);

namespace maarky\Test\Workflow\Task\Arr\Map;

use maarky\Workflow\Task\Arr\Filter;
use maarky\Workflow\Workflow;
use PHPUnit\Framework\TestCase;
use maarky\Workflow\Task\Utility;

class FilterTest extends TestCase
{
    protected $tasks;

    public function setUp()
    {
        $this->tasks = new class {
            use Filter, Utility;
        };
    }

    public function testKeyExists()
    {
        $workflow = Workflow::create(['a' => 1])->filter($this->tasks->keyExists('a'));
        $this->assertTrue($workflow->isDefined());
    }

    public function testKeyExists_notFound_empty()
    {
        $workflow = Workflow::create(['a' => 1])->filter($this->tasks->keyExists('b'));
        $this->assertTrue($workflow->isEmpty());
        return $workflow;
    }

    /**
     * @depends testKeyExists_notFound_empty
     */
    public function testKeyExists_notFound_notError(Workflow $workflow)
    {
        $this->assertFalse($workflow->isError());
    }

    public function testKeyExists_badKey()
    {
        $workflow = Workflow::create(['a' => 1])->filter($this->tasks->keyExists(new \stdClass()));
        $this->assertTrue($workflow->isEmpty());
    }
}