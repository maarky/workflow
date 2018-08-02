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
    }

    public function tearDown()
    {
        error_reporting($this->errorReporting);
    }

    public function testKeyCase_lower()
    {
        $upper = ['A' => 1];
        $expected = array_change_key_case($upper, CASE_LOWER);
        $actual = Workflow::create($upper)->map(Map\array_change_key_case())->get();
        $this->assertSame($expected, $actual);
    }

    public function testKeyCase_upper()
    {
        $lower = ['a' => 1];
        $expected = array_change_key_case($lower, CASE_UPPER);
        $actual = Workflow::create($lower)->map(Map\array_change_key_case(CASE_UPPER))->get();
        $this->assertSame($expected, $actual);
    }

    public function testChunk()
    {
        $array = [0,1,2,3,4,5,6,7,8,9];
        $size = 2;
        $expected = array_chunk($array, $size);
        $actual = Workflow::create($array)->map(Map\array_chunk($size))->get();
        $this->assertSame($expected, $actual);
    }

    public function testChunk_preserveKeys()
    {
        $array = [0,1,2,3,4,5,6,7,8,9];
        $size = 2;
        $expected = array_chunk($array, $size, true);
        $actual = Workflow::create($array)->map(Map\array_chunk($size, true))->get();
        $this->assertSame($expected, $actual);
    }

    public function testChunk_badSize()
    {
        $array = [0,1,2,3,4,5,6,7,8,9];
        $actual = Workflow::create($array)->map(Map\array_chunk(0))->isError();
        $this->assertTrue($actual);
    }

    public function testChunk_notArray()
    {
        $actual = Workflow::create(1)->map(Map\array_chunk(1))->isError();
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
        $actual = Workflow::create($array)->map(Map\array_column($column))->get();
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
        $actual = Workflow::create($array)->map(Map\array_column($column, $index))->get();
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
        $actual = Workflow::create($array)->map(Map\array_column($column, $index))->get();
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
        $actual = Workflow::create($array)->map(Map\array_column($column))->get();
        $this->assertSame($expected, $actual);
    }

    public function testColumn_notArray()
    {
        $array = 1;
        $column = 'a';
        $actual = Workflow::create($array)->map(Map\array_column($column))->isError();
        $this->assertTrue($actual);
    }

    public function testCountValues()
    {
        $array = [1,2,2,3,4,4,5];
        $expected = array_count_values($array);
        $actual = Workflow::create($array)->map(Map\array_count_values())->get();
        $this->assertSame($expected, $actual);
    }

    public function testCountValues_badValue()
    {
        $badArray = [1,2,2,3,4,4,5, new \stdClass()];
        $actual = Workflow::create($badArray)->map(Map\array_count_values())->isError();
        $this->assertTrue($actual);
    }

    public function testCountValues_notArray()
    {
        $badArray = 1;
        $actual = Workflow::create($badArray)->map(Map\array_count_values())->isError();
        $this->assertTrue($actual);
    }

    public function testFilter()
    {
        $array = [0,1,2,3,4,5,6,7,8,9];
        $filter = function ($num) { return $num & 1; };
        $expected = array_filter($array, $filter);
        $actual = Workflow::create($array)->map(Map\array_filter($filter))->get();
        $this->assertSame($expected, $actual);
    }

    public function testFilter_withKeys()
    {
        $array = [0,1,2,3,4,5,6,7,8,9];
        $filter = function ($key, $value) { return $key * $value; };
        $expected = array_filter($array, $filter, ARRAY_FILTER_USE_BOTH);
        $actual = Workflow::create($array)->map(Map\array_filter($filter, ARRAY_FILTER_USE_BOTH))->get();
        $this->assertSame($expected, $actual);
    }

    public function testFilter_notAray()
    {
        $array = 1;
        $filter = function () {};
        $actual = Workflow::create($array)->map(Map\array_filter($filter))->isError();
        $this->assertTrue($actual);
    }

    public function testFlip()
    {
        $array = [1 => 11, 2 => 22];
        $expected = array_flip($array);
        $actual = Workflow::create($array)->map(Map\array_flip())->get();
        $this->assertSame($expected, $actual);
    }

    public function testFlip_badData_error()
    {
        $array = [1 => 11, 2 => new \stdClass()];
        $actual = Workflow::create($array)->map(Map\array_flip())->isError();
        $this->assertTrue($actual);
    }

    public function testFillKeys()
    {
        $array = ['a', 'b', 'c'];
        $value = 1;
        $expected = array_fill_keys($array, $value);
        $actual = Workflow::create($array)->map(Map\array_fill_keys($value))->get();
        $this->assertSame($expected, $actual);
    }

    public function testFillKeys_notArray()
    {
        $array = 1;
        $value = 1;
        $actual = Workflow::create($array)->map(Map\array_fill_keys($value))->isError();
        $this->assertTrue($actual);
    }

    public function testFillKeys_badKey()
    {
        $array = ['a', 'b', ['a', 'b', 'c']];
        $value = 1;
        $actual = Workflow::create($array)->map(Map\array_fill_keys($value))->isError();
        $this->assertTrue($actual);
    }

    public function testKeys()
    {
        $array = ['blue', 'red', 'green', 'blue', 'blue'];
        $expected = array_keys($array);
        $actual = Workflow::create($array)->map(Map\array_keys())->get();
        $this->assertSame($expected, $actual);
    }

    public function testKeys_notArray()
    {
        $actual = Workflow::create(1)->map(Map\array_keys())->isError();
        $this->assertTrue($actual);
    }

    public function testKeys_search()
    {
        $array = ['blue', 'red', 'green', 'blue', 'blue'];
        $search = 'blue';
        $expected = array_keys($array, $search);
        $actual = Workflow::create($array)->map(Map\array_keys($search))->get();
        $this->assertSame($expected, $actual);
    }

    public function testKeys_search_strict()
    {
        $array = ['blue', 'red', 'green', 'blue', 'blue'];
        $search = 'blue';
        $strict = true;
        $expected = array_keys($array, $search, $strict);
        $actual = Workflow::create($array)->map(Map\array_keys($search, $strict))->get();
        $this->assertSame($expected, $actual);
    }

    public function testKeys_search_strict_noResult()
    {
        $array = ['blue', 'red', 'green', 'blue', 'blue'];
        $search = strtoupper('blue');
        $strict = true;
        $expected = array_keys($array, $search, $strict);
        $actual = Workflow::create($array)->map(Map\array_keys($search, $strict))->get();
        $this->assertSame($expected, $actual);
    }

    public function testMap()
    {
        $array1 = [1,2,3,4,5];
        $callback = function ($val) { return $val * 2; };
        $expected = array_map($callback, $array1);
        $actual = Workflow::create($array1)->map(Map\array_map($callback))->get();
        $this->assertSame($expected, $actual);
    }

    public function testMap_notArray()
    {
        $callback = function ($val) { return $val * 2; };
        $actual = Workflow::create(1)->map(Map\array_map($callback))->isError();
        $this->assertTrue($actual);
    }

    public function testMap_twoArrays()
    {
        $array1 = [1,2,3,4,5];
        $array2 = [6,7,8,9,0];
        $callback = function ($val) { return $val * 2; };
        $expected = array_map($callback, $array1, $array2);
        $actual = Workflow::create($array1)->map(Map\array_map($callback, $array2))->get();
        $this->assertSame($expected, $actual);
    }

    public function testMergeRecursive()
    {
        $array1 = ["color" => array("favorite" => "red"), 5];
        $array2 = [10, "color" => array("favorite" => "green", "blue")];
        $expected = array_merge_recursive($array1, $array2);
        $actual = Workflow::create($array1)->map(Map\array_merge_recursive($array2))->get();
        $this->assertSame($expected, $actual);
    }

    public function testMergeRecursive_notArray()
    {
        $array2 = [10, "color" => array("favorite" => "green", "blue")];
        $actual = Workflow::create(1)->map(Map\array_merge_recursive($array2))->isError();
        $this->assertTrue($actual);
    }

    public function testMerge()
    {
        $array1 = ["color" => "red", 2, 4];
        $array2 = ["a", "b", "color" => "green", "shape" => "trapezoid", 4];
        $expected = array_merge($array1, $array2);
        $actual = Workflow::create($array1)->map(Map\array_merge($array2))->get();
        $this->assertSame($expected, $actual);
    }

    public function testMerge_notArray()
    {
        $array2 = ["a", "b", "color" => "green", "shape" => "trapezoid", 4];
        $actual = Workflow::create(1)->map(Map\array_merge($array2))->isError();
        $this->assertTrue($actual);
    }

    public function testPad()
    {
        $array = [12, 10, 9];
        $size = 10;
        $value = 'a';
        $expected = array_pad($array, $size, $value);
        $actual = Workflow::create($array)->map(Map\array_pad($size, $value))->get();
        $this->assertSame($expected, $actual);
    }

    public function testPad_notArray()
    {
        $size = 10;
        $value = 'a';
        $actual = Workflow::create(1)->map(Map\array_pad($size, $value))->isError();
        $this->assertTrue($actual);
    }

    public function testTail()
    {
        $array = [1,2,3,4,5];
        $expected = [1 => 2, 2 => 3, 3 => 4, 4 => 5];
        $actual = Workflow::create($array)->map(Map\tail())->get();
        $this->assertSame($expected, $actual);
    }

    public function testTail_notArray()
    {
        $actual = Workflow::create(1)->map(Map\tail())->isError();
        $this->assertTrue($actual);
    }

    public function testInit()
    {
        $array = [1,2,3,4,5];
        $actual = Workflow::create($array)->map(Map\init())->get();
        $this->assertSame([1,2,3,4], $actual);
    }

    public function testInit_notArray()
    {
        $actual = Workflow::create(1)->map(Map\init())->isError();
        $this->assertTrue($actual);
    }

    public function testPush()
    {
        $array = [1,2,3];
        $value = 4;
        $actual = Workflow::create($array)->map(Map\array_push($value))->get();
        array_push($array, $value);
        $this->assertSame($array, $actual);
    }

    public function testPush_notArray()
    {
        $actual = Workflow::create(1)->map(Map\array_push(1))->isError();
        $this->assertTrue($actual);
    }

    public function testRand()
    {
        $array = [1,2,3,4];
        $keys = array_keys($array);
        $result = Workflow::create($array)->map(Map\array_rand())->get();
        $actual = array_pop($result);
        $this->assertContains($actual, $keys);
    }

    public function testRand_multiple()
    {
        $array = [1,2,3,4];
        $num = 2;
        $actual = Workflow::create($array)->map(Map\array_rand($num))->get();
        $keysArray = array_combine($actual, range(1, $num));
        $intersection = array_intersect_key($array, $keysArray);
        $this->assertCount($num, $intersection);
    }

    public function testRandValues()
    {
        $array = [1,11,111,1111,11111];
        $actual = Workflow::create($array)->map(Map\array_rand_values())->get();
        foreach ($actual as $key => $value) {
            $this->assertSame($array[$key], $value);
        }
    }

    public function testRandValues_multiple()
    {
        $array = [1,11,111,1111,11111];
        $num = 2;
        $actual = Workflow::create($array)->map(Map\array_rand_values($num))->get();
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
        $actual = Workflow::create($array1)->map(Map\array_replace($array2, $array3))->get();
        $this->assertSame($expected, $actual);
    }

    public function testReplace_notArray()
    {
        $array2 = array(0 => "pineapple", 4 => "cherry");
        $array3 = array(0 => "grape");
        $actual = Workflow::create(1)->map(Map\array_replace($array2, $array3))->isError();
        $this->assertTrue($actual);
    }

    public function testReplace_notArrayReplacement()
    {
        $array1 = array("orange", "banana", "apple", "raspberry");
        $actual = Workflow::create($array1)->map(Map\array_replace(1))->isError();
        $this->assertTrue($actual);
    }

    public function testReplaceRecursive()
    {
        $array1 = array('citrus' => array( "orange") , 'berries' => array("blackberry", "raspberry"), );
        $array2 = array('citrus' => array('pineapple'), 'berries' => array('blueberry'));
        $expected = array_replace_recursive($array1, $array2);
        $actual = Workflow::create($array1)->map(Map\array_replace_recursive($array2))->get();
        $this->assertSame($expected, $actual);
    }

    public function testReplaceRecursive_notArray()
    {
        $array2 = array('citrus' => array('pineapple'), 'berries' => array('blueberry'));
        $actual = Workflow::create(1)->map(Map\array_replace_recursive($array2))->isError();
        $this->assertTrue($actual);
    }

    public function testReplaceRecursive_notArrayReplacement()
    {
        $array1 = array('citrus' => array( "orange") , 'berries' => array("blackberry", "raspberry"), );
        $actual = Workflow::create($array1)->map(Map\array_replace_recursive(1))->isError();
        $this->assertTrue($actual);
    }
}