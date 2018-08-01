<?php
declare(strict_types=1);

namespace maarky\Test\Workflow\Task\Arr\Map;

use maarky\Workflow\Task\Arr\Filter;
use maarky\Workflow\Workflow;
use PHPUnit\Framework\TestCase;
use maarky\Workflow\Task\Arr;

class FilterTest extends TestCase
{
    protected $tasks;

    public function testKeyExists()
    {
        $workflow = Workflow::create(['a' => 1])->filter(Arr\array_key_exists('a'));
        $this->assertTrue($workflow->isDefined());
    }

    public function testKeyExists_notFound_empty()
    {
        $workflow = Workflow::create(['a' => 1])->filter(Arr\array_key_exists('b'));
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
        $workflow = Workflow::create(['a' => 1])->filter(Arr\array_key_exists(new \stdClass()));
        $this->assertTrue($workflow->isEmpty());
        return $workflow;
    }

    /**
     * @depends testKeyExists_badKey
     */
    public function testKeyExists_badKey_isError(Workflow $workflow)
    {
        $this->assertTrue($workflow->isError());
    }
}