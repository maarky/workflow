<?php
declare(strict_types=1);

namespace maarky\Test\Workflow\Task\Arr\Map;

use maarky\Workflow\Task\Arr\Map\Uintersect;
use maarky\Workflow\Workflow;
use PHPUnit\Framework\TestCase;
use maarky\Workflow\Task\Utility;

class UintersectTest extends TestCase
{
    protected $tasks;

    public function setUp()
    {
        $this->tasks = new class {
            use Uintersect, Utility;
        };
    }

    public function testAssoc()
    {
        $array1 = ["a" => "green", "b" => "brown", "c" => "blue", "red"];
        $array2 = ["a" => "GREEN", "B" => "brown", "yellow", "red"];
        $callback = 'strcasecmp';
        $expected = array_uintersect_assoc($array1, $array2, $callback);
        $actual = Workflow::create($array1)->map($this->tasks->uintersectAssoc($callback, $array2))->get();
        $this->assertSame($expected, $actual);
    }

    public function testAssoc_notArray()
    {
        $array2 = ["a" => "GREEN", "B" => "brown", "yellow", "red"];
        $callback = 'strcasecmp';
        $actual = Workflow::create(1)->map($this->tasks->uintersectAssoc($callback, $array2))->isError();
        $this->assertTrue($actual);
    }

    public function uassocData()
    {
        $array1 = ["a" => "green", "b" => "brown", "c" => "blue", "red"];
        $array2 = ["a" => "GREEN", "B" => "brown", "yellow", "red"];
        $valCompare = 'strcasecmp';
        $keyCompare = 'strcasecmp';
        return [
            ['uintersect uassoc: default usage', E_ALL, array_uintersect_uassoc($array1, $array2, $valCompare, $keyCompare), function() use ($array1, $array2, $valCompare, $keyCompare) { return Workflow::create($array1)->map($this->tasks->uintersectUassoc($valCompare, $keyCompare, $array2))->get(); }],
            ['uintersect uassoc: not array 1 - error', E_ALL, true, function() use ($array1, $array2, $valCompare, $keyCompare) { return Workflow::create(1)->map($this->tasks->uintersectUassoc($valCompare, $keyCompare, $array2))->isError(); }],
        ];
    }

    public function testUassoc()
    {
        $array1 = ["a" => "green", "b" => "brown", "c" => "blue", "red"];
        $array2 = ["a" => "GREEN", "B" => "brown", "yellow", "red"];
        $valCompare = 'strcasecmp';
        $keyCompare = 'strcasecmp';
        $expected = array_uintersect_uassoc($array1, $array2, $valCompare, $keyCompare);
        $actual = Workflow::create($array1)->map($this->tasks->uintersectUassoc($valCompare, $keyCompare, $array2))->get();
        $this->assertSame($expected, $actual);
    }

    public function testUassoc_notArray()
    {
        $array2 = ["a" => "GREEN", "B" => "brown", "yellow", "red"];
        $valCompare = 'strcasecmp';
        $keyCompare = 'strcasecmp';
        $actual = Workflow::create(1)->map($this->tasks->uintersectUassoc($valCompare, $keyCompare, $array2))->isError();
        $this->assertTrue($actual);
    }

    public function uintersectData()
    {
        $array1 = ["a" => "green", "b" => "brown", "c" => "blue", "red"];
        $array2 = ["a" => "GREEN", "B" => "brown", "yellow", "red"];
        $compare = 'strcasecmp';
        return [
            ['uintersect: default usage', E_ALL, array_uintersect($array1, $array2, $compare), function() use ($array1, $array2, $compare) { return Workflow::create($array1)->map($this->tasks->uintersect($compare, $array2))->get(); }],
            ['uintersect: not array 1 - error', E_ALL, true, function() use ($array1, $array2, $compare) { return Workflow::create(1)->map($this->tasks->uintersect($compare, $array2))->isError(); }],
        ];
    }

    public function testUintersect()
    {
        $array1 = ["a" => "green", "b" => "brown", "c" => "blue", "red"];
        $array2 = ["a" => "GREEN", "B" => "brown", "yellow", "red"];
        $compare = 'strcasecmp';
        $expected = array_uintersect($array1, $array2, $compare);
        $actual = Workflow::create($array1)->map($this->tasks->uintersect($compare, $array2))->get();
        $this->assertSame($expected, $actual);
    }

    public function testUintersect_notArray()
    {
        $array2 = ["a" => "GREEN", "B" => "brown", "yellow", "red"];
        $compare = 'strcasecmp';
        $actual = Workflow::create(1)->map($this->tasks->uintersect($compare, $array2))->isError();
        $this->assertTrue($actual);
    }
}
