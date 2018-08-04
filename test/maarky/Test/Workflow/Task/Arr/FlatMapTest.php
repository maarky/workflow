<?php
declare(strict_types=1);

namespace maarky\Test\Workflow\Task\Arr;

use maarky\Option\Option;
use maarky\Workflow\Task\Arr\FlatMap;
use maarky\Workflow\Workflow;
use PHPUnit\Framework\TestCase;

class FlatMapTest extends TestCase
{
    public function testProduct()
    {
        $array = [1,2,3,4,5];
        $expected = array_product($array);
        $actual = Workflow::create($array)->flatMap(FlatMap\array_product())->get();
        $this->assertSame($expected, $actual);
    }

    public function testProduct_OptionType()
    {
        $array = [1,2,3,4,5];
        $class = \maarky\Option\Type\Int\Option::class;
        $actual = Workflow::create($array)->flatMap(FlatMap\array_product($class));
        $this->assertInstanceOf($class, $actual);
    }

    public function testProduct_nonNumericValues()
    {
        $array = [1,2,3,4,'a'];
        $expected = array_product($array);
        $actual = Workflow::create($array)->flatMap(FlatMap\array_product())->get();
        $this->assertSame($expected, $actual);
    }

    public function testProduct_notArray()
    {
        $this->expectException(\TypeError::class);
        Workflow::create(1)->flatMap(FlatMap\array_product())->isError();
    }

    public function testReduce()
    {
        $array = [1,2,3,4,5];
        $expected = array_sum($array);
        $callable = function ($carry, $item) { return $carry + $item; };
        $actual = Workflow::create($array)->flatMap(FlatMap\array_reduce($callable));
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
        $actual = Workflow::create($array)->flatMap(FlatMap\array_reduce($callable, $initial))->get();
        $this->assertSame($expected, $actual);
    }

    public function testReduce_initial_workflowType()
    {
        $array = [1,2,3,4,5];
        $initial = 100;
        $callable = function ($carry, $item) { return $carry + $item; };
        $actual = Workflow::create($array)->flatMap(FlatMap\array_reduce($callable, $initial, \maarky\Workflow\Type\Int\Workflow::class));
        $this->assertInstanceOf(\maarky\Workflow\Type\Int\Workflow::class, $actual);
    }

    public function testReduce_initial_OptionType()
    {
        $array = [1,2,3,4,5];
        $initial = 100;
        $callable = function ($carry, $item) { return $carry + $item; };
        $class = Option::class;
        $actual = Workflow::create($array)->flatMap(FlatMap\array_reduce($callable, $initial, $class));
        $this->assertInstanceOf($class, $actual);
    }

    public function testReduce_initial_workflowType_empty()
    {
        $array = [1,2,3,4,5];
        $initial = 100;
        $callable = function ($carry, $item) { return 'a'; };
        $actual = Workflow::create($array)->flatMap(FlatMap\array_reduce($callable, $initial, \maarky\Workflow\Type\Int\Workflow::class));
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
        $actual = Workflow::create([])->flatMap(FlatMap\array_reduce($callable, $initial))->get();
        $this->assertSame($initial, $actual);
    }

    public function testReduce_notArray()
    {
        $this->expectException(\TypeError::class);
        $callable = function ($carry, $item) { return $carry + $item; };
        Workflow::create(1)->flatMap(FlatMap\array_reduce($callable))->isError();
    }

    public function testReduce_notCallable()
    {
        $this->expectException(\TypeError::class);
        Workflow::create([])->flatMap(FlatMap\array_reduce(1))->get();
    }

    public function testRand()
    {
        $array = [1,2,3,4];
        $keys = array_keys($array);
        $result = Workflow::create($array)->flatMap(FlatMap\array_rand())->get();
        $this->assertContains($result, $keys);
    }

    public function testRandValue()
    {
        $array = [1,2,3,4];
        $result = Workflow::create($array)->flatMap(FlatMap\array_rand_value())->get();
        $this->assertContains($result, $array);
    }

    public function testSearch()
    {
        $array = [1,2,3];
        $needle = 2;
        $expected = \array_search($needle, $array);
        $actual = Workflow::create($array)->flatMap(FlatMap\array_search($needle))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testSearch_notStrict()
    {
        $array = [1,2,3];
        $needle = '2';
        $expected = \array_search($needle, $array);
        $actual = Workflow::create($array)->flatMap(FlatMap\array_search($needle))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testSearch_strict()
    {
        $array = [1,2,3];
        $needle = '2';
        $actual = Workflow::create($array)->flatMap(FlatMap\array_search($needle, true));
        $this->assertTrue($actual->isEmpty());
    }

    public function testShift()
    {
        $array = [1,2,3,4,5];
        $actual = Workflow::create($array)->flatMap(FlatMap\array_shift());
        $this->assertSame(1, $actual->get());
        return $actual;
    }

    /**
     * @depends testShift
     */
    public function testShift_type_workflow($workflow)
    {
        $this->assertInstanceOf(Workflow::class, $workflow);
    }

    public function testShift_notArray()
    {
        $actual = Workflow::create(1)->map(FlatMap\array_shift())->isError();
        $this->assertTrue($actual);
    }

    public function testShift_type_option()
    {
        $array = [1,2,3,4,5];
        $optionType = \maarky\Option\Type\Int\Option::class;
        $actual = Workflow::create($array)->flatMap(FlatMap\array_shift($optionType));
        $this->assertInstanceOf($optionType, $actual);
    }

    public function testSum()
    {
        $array = [1,2,3,4,5];
        $expected = array_sum($array);
        $actual = Workflow::create($array)->flatMap(FlatMap\array_sum())->get();
        $this->assertEquals($expected, $actual);
    }

    public function testSum_class()
    {
        $array = [1,2,3,4,5];
        $expected = array_sum($array);
        $actual = Workflow::create($array)->flatMap(FlatMap\array_sum(\maarky\Workflow\Type\Int\Workflow::class));
        $this->assertEquals($expected, $actual->get());
        return $actual;
    }

    /**
     * @depends testSum_class
     */
    public function testSum_class_correctType($workflow)
    {
        $this->assertInstanceOf(\maarky\Workflow\Type\Int\Workflow::class, $workflow);
    }

    public function testCount()
    {
        $array = [1,2,3,4,5];
        $expected = count($array);
        $actual = Workflow::create($array)->flatMap(FlatMap\count())->get();
        $this->assertEquals($expected, $actual);
    }
}