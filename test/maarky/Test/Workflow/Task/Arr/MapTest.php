<?php
declare(strict_types=1);

namespace maarky\Test\Workflow\Task\Arr\Map;

use maarky\Workflow\Task\Utility;
use maarky\Workflow\Task\Arr\Map;
use maarky\Workflow\Workflow;
use PHPUnit\Framework\TestCase;

class MapTest extends TestCase
{
    protected $errorReporting;
    protected $tasks;

    public function setUp()
    {
        $this->errorReporting = error_reporting(E_ALL);
        $this->tasks = new class {
            use Map, Utility;
        };
    }

    public function tearDown()
    {
        error_reporting($this->errorReporting);
    }

    public function testKeyCase_lower()
    {
        $upper = ['A' => 1];
        $expected = array_change_key_case($upper, CASE_LOWER);
        $actual = Workflow::new($upper)->map($this->tasks->changeKeyCase())->get();
        $this->assertSame($expected, $actual);
    }

    public function testKeyCase_upper()
    {
        $lower = ['a' => 1];
        $expected = array_change_key_case($lower, CASE_UPPER);
        $actual = Workflow::new($lower)->map($this->tasks->changeKeyCase(CASE_UPPER))->get();
        $this->assertSame($expected, $actual);
    }

    public function testChunk()
    {
        $array = [0,1,2,3,4,5,6,7,8,9];
        $size = 2;
        $expected = array_chunk($array, $size);
        $actual = Workflow::new($array)->map($this->tasks->chunk($size))->get();
        $this->assertSame($expected, $actual);
    }

    public function testChunk_preserveKeys()
    {
        $array = [0,1,2,3,4,5,6,7,8,9];
        $size = 2;
        $expected = array_chunk($array, $size, true);
        $actual = Workflow::new($array)->map($this->tasks->chunk($size, true))->get();
        $this->assertSame($expected, $actual);
    }

    public function testChunk_badSize()
    {
        $array = [0,1,2,3,4,5,6,7,8,9];
        $actual = Workflow::new($array)->map($this->tasks->chunk(0))->isError();
        $this->assertTrue($actual);
    }

    public function testChunk_notArray()
    {
        $actual = Workflow::new(1)->map($this->tasks->chunk(1))->isError();
        $this->assertTrue($actual);
    }

    public function testColumn()
    {
        $array = [
            ['a' => 1, 'b' => 2],
            ['a' => 11, 'b' => 22]
        ];
        $column = 'a';
        $expected = array_column($array, $column);
        $actual = Workflow::new($array)->map($this->tasks->column($column))->get();
        $this->assertSame($expected, $actual);
    }

    public function testColumn_index()
    {
        $array = [
            ['a' => 1, 'b' => 2],
            ['a' => 11, 'b' => 22]
        ];
        $column = 'a';
        $index = 'b';
        $expected = array_column($array, $column, $index);
        $actual = Workflow::new($array)->map($this->tasks->column($column, $index))->get();
        $this->assertSame($expected, $actual);
    }

    public function testColumn_badIndex()
    {
        $array = [
            ['a' => 1, 'b' => 2],
            ['a' => 11, 'b' => 22]
        ];
        $column = 'a';
        $index = 'c';
        $expected = array_column($array, $column, $index);
        $actual = Workflow::new($array)->map($this->tasks->column($column, $index))->get();
        $this->assertSame($expected, $actual);
    }

    public function testColumn_badColumn()
    {
        $array = [
            ['a' => 1, 'b' => 2],
            ['a' => 11, 'b' => 22]
        ];
        $column = 'c';
        $expected = array_column($array, $column);
        $actual = Workflow::new($array)->map($this->tasks->column($column))->get();
        $this->assertSame($expected, $actual);
    }

    public function testColumn_notArray()
    {
        $array = 1;
        $column = 'a';
        $actual = Workflow::new($array)->map($this->tasks->column($column))->isError();
        $this->assertTrue($actual);
    }

    public function testCountValues()
    {
        $array = [1,2,2,3,4,4,5];
        $expected = array_count_values($array);
        $actual = Workflow::new($array)->map($this->tasks->countValues())->get();
        $this->assertSame($expected, $actual);
    }

    public function testCountValues_badValue()
    {
        $badArray = [1,2,2,3,4,4,5, new \stdClass()];
        $actual = Workflow::new($badArray)->map($this->tasks->countValues())->isError();
        $this->assertTrue($actual);
    }

    public function testCountValues_notArray()
    {
        $badArray = 1;
        $actual = Workflow::new($badArray)->map($this->tasks->countValues())->isError();
        $this->assertTrue($actual);
    }

    public function testFilter()
    {
        $array = [0,1,2,3,4,5,6,7,8,9];
        $filter = function ($num) { return $num & 1; };
        $expected = array_filter($array, $filter);
        $actual = Workflow::new($array)->map($this->tasks->filter($filter))->get();
        $this->assertSame($expected, $actual);
    }

    public function testFilter_withKeys()
    {
        $array = [0,1,2,3,4,5,6,7,8,9];
        $filter = function ($key, $value) { return $key * $value; };
        $expected = array_filter($array, $filter, ARRAY_FILTER_USE_BOTH);
        $actual = Workflow::new($array)->map($this->tasks->filter($filter, ARRAY_FILTER_USE_BOTH))->get();
        $this->assertSame($expected, $actual);
    }

    public function testFilter_notAray()
    {
        $array = 1;
        $filter = function () {};
        $actual = Workflow::new($array)->map($this->tasks->filter($filter))->isError();
        $this->assertTrue($actual);
    }

    public function testFlip()
    {
        $array = [1 => 11, 2 => 22];
        $expected = array_flip($array);
        $actual = Workflow::new($array)->map($this->tasks->flip())->get();
        $this->assertSame($expected, $actual);
    }

    public function testFlip_badData_error()
    {
        $array = [1 => 11, 2 => new \stdClass()];
        $actual = Workflow::new($array)->map($this->tasks->flip())->isError();
        $this->assertTrue($actual);
    }

    public function testFillKeys()
    {
        $array = ['a', 'b', 'c'];
        $value = 1;
        $expected = array_fill_keys($array, $value);
        $actual = Workflow::new($array)->map($this->tasks->fillKeys($value))->get();
        $this->assertSame($expected, $actual);
    }

    public function testFillKeys_notArray()
    {
        $array = 1;
        $value = 1;
        $actual = Workflow::new($array)->map($this->tasks->fillKeys($value))->isError();
        $this->assertTrue($actual);
    }

    public function testFillKeys_badKey()
    {
        $array = ['a', 'b', ['a', 'b', 'c']];
        $value = 1;
        $actual = Workflow::new($array)->map($this->tasks->fillKeys($value))->isError();
        $this->assertTrue($actual);
    }

    public function testKeys()
    {
        $array = ['blue', 'red', 'green', 'blue', 'blue'];
        $expected = array_keys($array);
        $actual = Workflow::new($array)->map($this->tasks->keys())->get();
        $this->assertSame($expected, $actual);
    }

    public function testKeys_notArray()
    {
        $actual = Workflow::new(1)->map($this->tasks->keys())->isError();
        $this->assertTrue($actual);
    }

    public function testKeys_search()
    {
        $array = ['blue', 'red', 'green', 'blue', 'blue'];
        $search = 'blue';
        $expected = array_keys($array, $search);
        $actual = Workflow::new($array)->map($this->tasks->keys($search))->get();
        $this->assertSame($expected, $actual);
    }

    public function testKeys_search_strict()
    {
        $array = ['blue', 'red', 'green', 'blue', 'blue'];
        $search = 'blue';
        $strict = true;
        $expected = array_keys($array, $search, $strict);
        $actual = Workflow::new($array)->map($this->tasks->keys($search, $strict))->get();
        $this->assertSame($expected, $actual);
    }

    public function testKeys_search_strict_noResult()
    {
        $array = ['blue', 'red', 'green', 'blue', 'blue'];
        $search = strtoupper('blue');
        $strict = true;
        $expected = array_keys($array, $search, $strict);
        $actual = Workflow::new($array)->map($this->tasks->keys($search, $strict))->get();
        $this->assertSame($expected, $actual);
    }

    public function testMap()
    {
        $array1 = [1,2,3,4,5];
        $callback = function ($val) { return $val * 2; };
        $expected = array_map($callback, $array1);
        $actual = Workflow::new($array1)->map($this->tasks->map($callback))->get();
        $this->assertSame($expected, $actual);
    }

    public function testMap_notArray()
    {
        $callback = function ($val) { return $val * 2; };
        $actual = Workflow::new(1)->map($this->tasks->map($callback))->isError();
        $this->assertTrue($actual);
    }

    public function testMap_twoArrays()
    {
        $array1 = [1,2,3,4,5];
        $array2 = [6,7,8,9,0];
        $callback = function ($val) { return $val * 2; };
        $expected = array_map($callback, $array1, $array2);
        $actual = Workflow::new($array1)->map($this->tasks->map($callback, $array2))->get();
        $this->assertSame($expected, $actual);
    }

    public function testMergeRecursive()
    {
        $array1 = ["color" => array("favorite" => "red"), 5];
        $array2 = [10, "color" => array("favorite" => "green", "blue")];
        $expected = array_merge_recursive($array1, $array2);
        $actual = Workflow::new($array1)->map($this->tasks->mergeRecursive($array2))->get();
        $this->assertSame($expected, $actual);
    }

    public function testMergeRecursive_notArray()
    {
        $array2 = [10, "color" => array("favorite" => "green", "blue")];
        $actual = Workflow::new(1)->map($this->tasks->mergeRecursive($array2))->isError();
        $this->assertTrue($actual);
    }

    public function testMerge()
    {
        $array1 = ["color" => "red", 2, 4];
        $array2 = ["a", "b", "color" => "green", "shape" => "trapezoid", 4];
        $expected = array_merge($array1, $array2);
        $actual = Workflow::new($array1)->map($this->tasks->merge($array2))->get();
        $this->assertSame($expected, $actual);
    }

    public function testMerge_notArray()
    {
        $array2 = ["a", "b", "color" => "green", "shape" => "trapezoid", 4];
        $actual = Workflow::new(1)->map($this->tasks->merge($array2))->isError();
        $this->assertTrue($actual);
    }

    public function testPad()
    {
        $array = [12, 10, 9];
        $size = 10;
        $value = 'a';
        $expected = array_pad($array, $size, $value);
        $actual = Workflow::new($array)->map($this->tasks->pad($size, $value))->get();
        $this->assertSame($expected, $actual);
    }

    public function testPad_notArray()
    {
        $size = 10;
        $value = 'a';
        $actual = Workflow::new(1)->map($this->tasks->pad($size, $value))->isError();
        $this->assertTrue($actual);
    }

    public function testHead()
    {
        $array = [1,2,3,4,5];
        $actual = Workflow::new($array)->map($this->tasks->head())->get();
        $this->assertSame(1, $actual);
    }

    public function testHead_notArray()
    {
        $actual = Workflow::new(1)->map($this->tasks->head())->isError();
        $this->assertTrue($actual);
    }

    public function testTail()
    {
        $array = [1,2,3,4,5];
        $expected = [1 => 2, 2 => 3, 3 => 4, 4 => 5];
        $actual = Workflow::new($array)->map($this->tasks->tail())->get();
        $this->assertSame($expected, $actual);
    }

    public function testTail_notArray()
    {
        $actual = Workflow::new(1)->map($this->tasks->tail())->isError();
        $this->assertTrue($actual);
    }

    public function testLast()
    {
        $last = 5;
        $array = [1,2,3,4,$last];
        $actual = Workflow::new($array)->map($this->tasks->last())->get();
        $this->assertSame($last, $actual);
    }

    public function testLast_notArray()
    {
        $actual = Workflow::new(1)->map($this->tasks->last())->isError();
        $this->assertTrue($actual);
    }

    public function testInit()
    {
        $array = [1,2,3,4,5];
        $actual = Workflow::new($array)->map($this->tasks->init())->get();
        $this->assertSame([1,2,3,4], $actual);
    }

    public function testInit_notArray()
    {
        $actual = Workflow::new(1)->map($this->tasks->init())->isError();
        $this->assertTrue($actual);
    }

    public function testPush()
    {
        $array = [1,2,3];
        $value = 4;
        $actual = Workflow::new($array)->map($this->tasks->push($value))->get();
        array_push($array, $value);
        $this->assertSame($array, $actual);
    }

    public function testPush_notArray()
    {
        $actual = Workflow::new(1)->map($this->tasks->push(1))->isError();
        $this->assertTrue($actual);
    }

    public function testRand()
    {
        $array = [1,2,3,4];
        $actual = Workflow::new($array)->map($this->tasks->rand())->get();
        $this->assertContains($actual, array_keys($array));
    }

    public function testRand_multiple()
    {
        $array = [1,2,3,4];
        $num = 2;
        $actual = Workflow::new($array)->map($this->tasks->rand($num))->get();
        $keysArray = array_combine($actual, range(1, $num));
        $intersection = array_intersect_key($array, $keysArray);
        $this->assertCount($num, $intersection);
    }

    public function testRandValues()
    {
        $array = [1,11,111,1111,11111];
        $actual = Workflow::new($array)->map($this->tasks->randValues())->get();
        foreach ($actual as $key => $value) {
            $this->assertSame($array[$key], $value);
        }
    }

    public function testRandValues_multiple()
    {
        $array = [1,11,111,1111,11111];
        $num = 2;
        $actual = Workflow::new($array)->map($this->tasks->randValues($num))->get();
        foreach ($actual as $key => $value) {
            $this->assertSame($array[$key], $value);
        }
    }

    public function testReplace()
    {
        $array1 = array("orange", "banana", "apple", "raspberry");
        $array2 = array(0 => "pineapple", 4 => "cherry");
        $array3 = array(0 => "grape");
        $expected = array_replace($array1, $array2, $array3);
        $actual = Workflow::new($array1)->map($this->tasks->replace($array2, $array3))->get();
        $this->assertSame($expected, $actual);
    }

    public function testReplace_notArray()
    {
        $array2 = array(0 => "pineapple", 4 => "cherry");
        $array3 = array(0 => "grape");
        $actual = Workflow::new(1)->map($this->tasks->replace($array2, $array3))->isError();
        $this->assertTrue($actual);
    }

    public function testReplace_notArrayReplacement()
    {
        $array1 = array("orange", "banana", "apple", "raspberry");
        $actual = Workflow::new($array1)->map($this->tasks->replace(1))->isError();
        $this->assertTrue($actual);
    }

    public function testReplaceRecursive()
    {
        $array1 = array('citrus' => array( "orange") , 'berries' => array("blackberry", "raspberry"), );
        $array2 = array('citrus' => array('pineapple'), 'berries' => array('blueberry'));
        $expected = array_replace_recursive($array1, $array2);
        $actual = Workflow::new($array1)->map($this->tasks->replaceRecursive($array2))->get();
        $this->assertSame($expected, $actual);
    }

    public function testReplaceRecursive_notArray()
    {
        $array2 = array('citrus' => array('pineapple'), 'berries' => array('blueberry'));
        $actual = Workflow::new(1)->map($this->tasks->replaceRecursive($array2))->isError();
        $this->assertTrue($actual);
    }

    public function testReplaceRecursive_notArrayReplacement()
    {
        $array1 = array('citrus' => array( "orange") , 'berries' => array("blackberry", "raspberry"), );
        $actual = Workflow::new($array1)->map($this->tasks->replaceRecursive(1))->isError();
        $this->assertTrue($actual);
    }
}