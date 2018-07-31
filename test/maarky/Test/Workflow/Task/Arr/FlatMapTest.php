<?php
declare(strict_types=1);

namespace maarky\Test\Workflow\Task\Arr\Map;

use maarky\Option\Option;
use maarky\Workflow\Task\Arr\FlapMap;
use maarky\Workflow\Workflow;
use PHPUnit\Framework\TestCase;
use maarky\Workflow\Task\Utility;

class FlatMapTest extends TestCase
{
    protected $tasks;

    public function setUp()
    {
        $this->tasks = new class {
            use FlapMap, Utility;
        };
    }

    public function testProduct()
    {
        $array = [1,2,3,4,5];
        $expected = array_product($array);
        $actual = Workflow::create($array)->flatMap($this->tasks->product())->get();
        $this->assertSame($expected, $actual);
    }

    public function testProduct_OptionType()
    {
        $array = [1,2,3,4,5];
        $class = \maarky\Option\Type\Int\Option::class;
        $actual = Workflow::create($array)->flatMap($this->tasks->product($class));
        $this->assertInstanceOf($class, $actual);
    }

    public function testProduct_nonNumericValues()
    {
        $array = [1,2,3,4,'a'];
        $expected = array_product($array);
        $actual = Workflow::create($array)->flatMap($this->tasks->product())->get();
        $this->assertSame($expected, $actual);
    }

    public function testProduct_notArray()
    {
        $this->expectException(\TypeError::class);
        Workflow::create(1)->flatMap($this->tasks->product())->isError();
    }

    public function testReduce()
    {
        $array = [1,2,3,4,5];
        $expected = array_sum($array);
        $callable = function ($carry, $item) { return $carry + $item; };
        $actual = Workflow::create($array)->flatMap($this->tasks->reduce($callable));
        $this->assertSame($expected, $actual->get());
        return $actual;
    }

    /**
     * @depends testReduce
     */
    public function testReduce_isBaseWorkflowType(Workflow $workflow)
    {
        $this->assertInstanceOf(Workflow::class, $workflow);
    }

    public function testReduce_initial()
    {
        $array = [1,2,3,4,5];
        $initial = 100;
        $expected = array_sum($array) + $initial;
        $callable = function ($carry, $item) { return $carry + $item; };
        $actual = Workflow::create($array)->flatMap($this->tasks->reduce($callable, $initial))->get();
        $this->assertSame($expected, $actual);
    }

    public function testReduce_initial_workflowType()
    {
        $array = [1,2,3,4,5];
        $initial = 100;
        $callable = function ($carry, $item) { return $carry + $item; };
        $actual = Workflow::create($array)->flatMap($this->tasks->reduce($callable, $initial, \maarky\Workflow\Type\Int\Workflow::class));
        $this->assertInstanceOf(\maarky\Workflow\Type\Int\Workflow::class, $actual);
    }

    public function testReduce_initial_OptionType()
    {
        $array = [1,2,3,4,5];
        $initial = 100;
        $callable = function ($carry, $item) { return $carry + $item; };
        $class = Option::class;
        $actual = Workflow::create($array)->flatMap($this->tasks->reduce($callable, $initial, $class));
        $this->assertInstanceOf($class, $actual);
    }

    public function testReduce_initial_workflowType_empty()
    {
        $array = [1,2,3,4,5];
        $initial = 100;
        $callable = function ($carry, $item) { return 'a'; };
        $actual = Workflow::create($array)->flatMap($this->tasks->reduce($callable, $initial, \maarky\Workflow\Type\Int\Workflow::class));
        $this->assertTrue($actual->isEmpty());
        return $actual;
    }

    /**
     * @depends testReduce_initial_workflowType_empty
     */
    public function testReduce_initial_workflowType_notError(Workflow $workflow)
    {
        $this->assertFalse($workflow->isError());
    }

    public function testReduce_initial_emptyArray()
    {
        $initial = 100;
        $callable = function ($carry, $item) { return $carry + $item; };
        $actual = Workflow::create([])->flatMap($this->tasks->reduce($callable, $initial))->get();
        $this->assertSame($initial, $actual);
    }

    public function testReduce_notArray()
    {
        $this->expectException(\TypeError::class);
        $callable = function ($carry, $item) { return $carry + $item; };
        Workflow::create(1)->flatMap($this->tasks->reduce($callable))->isError();
    }

    public function testReduce_notCallable()
    {
        $this->expectException(\TypeError::class);
        Workflow::create([])->flatMap($this->tasks->reduce(1))->get();
    }
}