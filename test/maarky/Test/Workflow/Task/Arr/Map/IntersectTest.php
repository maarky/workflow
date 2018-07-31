<?php
declare(strict_types=1);

namespace maarky\Test\Workflow\Task\Arr\Map;

use maarky\Workflow\Task\Arr\Map\Intersect;
use maarky\Workflow\Workflow;
use PHPUnit\Framework\TestCase;
use maarky\Workflow\Task\Utility;

class IntersectTest extends TestCase
{
    protected $tasks;

    public function setUp()
    {
        $this->tasks = new class {
            use Intersect, Utility;
        };
    }

    public function testAssoc()
    {
        $array1 = ["a" => "green", "b" => "brown", "c" => "blue", "red"];
        $array2 = ["a" => "green", "b" => "yellow", "blue", "red"];
        $expected = array_intersect_assoc($array1, $array2);
        $actual = Workflow::create($array1)->map($this->tasks->intersectAssoc($array2))->get();
        $this->assertSame($expected, $actual);
    }

    public function testAssoc_notArray()
    {
        $array2 = ["a" => "green", "b" => "yellow", "blue", "red"];
        $actual = Workflow::create(1)->map($this->tasks->intersectAssoc($array2))->isError();
        $this->assertTrue($actual);
    }

    public function testKey()
    {
        $array1 = ['blue'  => 1, 'red'  => 2, 'green'  => 3, 'purple' => 4];
        $array2 = ['green' => 5, 'blue' => 6, 'yellow' => 7, 'cyan'   => 8];
        $expected = array_intersect_key($array1, $array2);
        $actual = Workflow::create($array1)->map($this->tasks->intersectKey($array2))->get();
        $this->assertSame($expected, $actual);
    }

    public function testKey_notArray()
    {
        $array2 = ['green' => 5, 'blue' => 6, 'yellow' => 7, 'cyan'   => 8];
        $actual = Workflow::create(1)->map($this->tasks->intersectKey($array2))->isError();
        $this->assertTrue($actual);
    }

    public function testUassoc()
    {
        $array1 = ["a" => "green", "b" => "brown", "c" => "blue", "red"];
        $array2 = ["a" => "GREEN", "B" => "brown", "yellow", "red"];
        $keyCompare = function($a, $b) {
            return $a <=> $b;
        };
        $expected = array_intersect_uassoc($array1, $array2, $keyCompare);
        $actual = Workflow::create($array1)->map($this->tasks->intersectUassoc($keyCompare, $array2))->get();
        $this->assertSame($expected, $actual);
    }

    public function testUassoc_notArray()
    {
        $array2 = ["a" => "GREEN", "B" => "brown", "yellow", "red"];
        $keyCompare = function($a, $b) {
            return $a <=> $b;
        };
        $actual = Workflow::create(1)->map($this->tasks->intersectUassoc($keyCompare, $array2))->isError();
        $this->assertTrue($actual);
    }

    public function testUkey()
    {
        $array1 = ['blue'  => 1, 'red'  => 2, 'green'  => 3, 'purple' => 4];
        $array2 = ['green' => 5, 'blue' => 6, 'yellow' => 7, 'cyan'   => 8];
        $keyCompare = function($a, $b) {
            return $a <=> $b;
        };
        $expected = array_intersect_ukey($array1, $array2, $keyCompare);
        $actual = Workflow::create($array1)->map($this->tasks->intersectUkey($keyCompare, $array2))->get();
        $this->assertSame($expected, $actual);
    }

    public function testUkey_notArray()
    {
        $array2 = ['green' => 5, 'blue' => 6, 'yellow' => 7, 'cyan'   => 8];
        $keyCompare = function($a, $b) {
            return $a <=> $b;
        };
        $actual = Workflow::create(1)->map($this->tasks->intersectUkey($keyCompare, $array2))->isError();
        $this->assertTrue($actual);
    }

    public function testIntersect()
    {
        $array1 = ["a" => "green", "red", "blue"];
        $array2 = ["b" => "green", "yellow", "red"];
        $expected = array_intersect($array1, $array2);
        $actual = Workflow::create($array1)->map($this->tasks->intersect($array2))->get();
        $this->assertSame($expected, $actual);
    }

    public function testIntersect_notArray()
    {
        $array2 = ["b" => "green", "yellow", "red"];
        $actual = Workflow::create(1)->map($this->tasks->intersect($array2))->isError();
        $this->assertTrue($actual);
    }
}