<?php
declare(strict_types=1);

namespace maarky\Test\Workflow\Task\Arr\Map;

use maarky\Workflow\Task\Arr\Map\Diff;
use maarky\Workflow\Workflow;
use PHPUnit\Framework\TestCase;
use maarky\Workflow\Task\Utility;

class DiffTest extends TestCase
{
    protected $tasks;

    public function setUp()
    {
        $this->tasks = new class {
            use Diff, Utility;
        };
    }

    public function testAssoc()
    {
        $array1 = ["a" => "green", "b" => "brown", "c" => "blue", "red"];
        $array2 = ["a" => "green", "yellow", "red"];
        $expected = array_diff_assoc($array1, $array2);
        $actual = Workflow::create($array1)->map($this->tasks->diffAssoc($array2))->get();
        $this->assertSame($expected, $actual);
    }

    public function testAssoc_notArray()
    {
        $array2 = ["a" => "green", "yellow", "red"];
        $actual = Workflow::create(1)->map($this->tasks->diffAssoc($array2))->isError();
        $this->assertTrue($actual);
    }

    public function testKey()
    {
        $array1 = ['blue' => 1, 'red' => 2, 'green' => 3, 'purple' => 4];
        $array2 = ['green' => 5, 'yellow' => 7, 'cyan' => 8];
        $expected = array_diff_key($array1, $array2);
        $actual = Workflow::create($array1)->map($this->tasks->diffKey($array2))->get();
        $this->assertSame($expected, $actual);
    }

    public function testKey_notArray()
    {
        $array2 = ['green' => 5, 'yellow' => 7, 'cyan' => 8];
        $actual = Workflow::create(1)->map($this->tasks->diffKey($array2))->isError();
        $this->assertTrue($actual);
    }

    public function testUassoc()
    {
        $array1 = ["a" => "green", "b" => "brown", "c" => "blue", "red"];
        $array2 = ["a" => "green", "yellow", "red"];
        $keyCompare = function($a, $b) {
            return $a <=> $b;
        };
        $expected = array_diff_uassoc($array1, $array2, $keyCompare);
        $actual = Workflow::create($array1)->map($this->tasks->diffUassoc($keyCompare, $array2))->get();
        $this->assertSame($expected, $actual);
    }

    public function testUassoc_notArray()
    {
        $array2 = ["a" => "green", "yellow", "red"];
        $keyCompare = function($a, $b) {
            return $a <=> $b;
        };
        $actual = Workflow::create(1)->map($this->tasks->diffUassoc($keyCompare, $array2))->isError();
        $this->assertTrue($actual);
    }

    public function testUkey()
    {
        $array1 = ['blue' => 1, 'red' => 2, 'green' => 3, 'purple' => 4];
        $array2 = ['green' => 5, 'yellow' => 7, 'cyan' => 8];
        $keyCompare = function($a, $b) {
            return $a <=> $b;
        };
        $expected = array_diff_ukey($array1, $array2, $keyCompare);
        $actual = Workflow::create($array1)->map($this->tasks->diffUkey($keyCompare, $array2))->get();
        $this->assertSame($expected, $actual);
    }

    public function testUkey_notArray()
    {
        $array2 = ['green' => 5, 'yellow' => 7, 'cyan' => 8];
        $keyCompare = function($a, $b) {
            return $a <=> $b;
        };
        $actual = Workflow::create(1)->map($this->tasks->diffUkey($keyCompare, $array2))->isError();
        $this->assertTrue($actual);
    }

    public function testDiff()
    {
        $array1 = ["a" => "green", "red", "blue", "red"];
        $array2 = ["b" => "green", "yellow", "red"];
        $expected = array_diff($array1, $array2);
        $actual = Workflow::create($array1)->map($this->tasks->diff($array2))->get();
        $this->assertSame($expected, $actual);
    }

    public function testDiff_notArray()
    {
        $array2 = ["b" => "green", "yellow", "red"];
        $actual = Workflow::create(1)->map($this->tasks->diff($array2))->isError();
        $this->assertTrue($actual);
    }
}