<?php
declare(strict_types=1);

namespace maarky\Test\Workflow\Task\Arr\Map;

use maarky\Workflow\Task\Arr\Map\Sort;
use maarky\Workflow\Workflow;
use PHPUnit\Framework\TestCase;

class SortTest extends TestCase
{
    public function testReverse()
    {
        $array = [1,2];
        $expected = array_reverse($array);
        $actual = Workflow::create($array)->map(Sort\array_reverse())->get();
        $this->assertEquals($expected, $actual);
    }

    public function testReverse_preserveKeys()
    {
        $array = [1,2];
        $expected = array_reverse($array, true);
        $actual = Workflow::create($array)->map(Sort\array_reverse(true))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testArsort()
    {
        $array = ['3b', '3d'];
        $expected = $array;
        arsort($expected);
        $actual = Workflow::create($array)->map(Sort\arsort())->get();
        $this->assertEquals($expected, $actual);
    }

    public function testArsort_flags()
    {
        $array = ['3b', '3d'];
        $expected = $array;
        $flag = SORT_NUMERIC;
        arsort($expected, $flag);
        $actual = Workflow::create($array)->map(Sort\arsort($flag))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testAsort()
    {
        $array = ['3d', '3b'];
        $expected = $array;
        asort($expected);
        $actual = Workflow::create($array)->map(Sort\asort())->get();
        $this->assertEquals($expected, $actual);
    }

    public function testAsort_flags()
    {
        $array = ['3d', '3b'];
        $expected = $array;
        $flag = SORT_NUMERIC;
        asort($expected, $flag);
        $actual = Workflow::create($array)->map(Sort\asort($flag))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testKrsort()
    {
        $array = ['3b' => 1, '3d' => 2];
        $expected = $array;
        krsort($expected);
        $actual = Workflow::create($array)->map(Sort\krsort())->get();
        $this->assertEquals($expected, $actual);
    }

    public function testKrsort_flags()
    {
        $array = ['3b' => 1, '3d' => 2];
        $expected = $array;
        $flag = SORT_NUMERIC;
        krsort($expected, $flag);
        $actual = Workflow::create($array)->map(Sort\krsort($flag))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testKsort()
    {
        $array = ['3d' => 1, '3b' => 2];
        $expected = $array;
        ksort($expected);
        $actual = Workflow::create($array)->map(Sort\ksort())->get();
        $this->assertEquals($expected, $actual);
    }

    public function testKsort_flags()
    {
        $array = ['3d' => 1, '3b' => 2];
        $expected = $array;
        $flag = SORT_NUMERIC;
        ksort($expected, $flag);
        $actual = Workflow::create($array)->map(Sort\ksort($flag))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testNatcasesort()
    {
        $array = ['a','B', 'c'];
        $actual = Workflow::create($array)->map(Sort\natcasesort())->get();
        $this->assertEquals($array, $actual);
    }

    public function testNatsort()
    {
        $array = ['a1','a2', 'a22'];
        $actual = Workflow::create($array)->map(Sort\natsort())->get();
        $this->assertEquals($array, $actual);
    }

    public function testRsort()
    {
        $array = ['3c', '3b', '3a'];
        $actual = Workflow::create($array)->map(Sort\rsort())->get();
        $this->assertEquals($array, $actual);
    }

    public function testRsort_flags()
    {
        $array = ['3a', '3b', '3c'];
        $flag = SORT_NUMERIC;
        $actual = Workflow::create($array)->map(Sort\rsort($flag))->get();
        $this->assertEquals($array, $actual);
    }

    public function testShuffle()
    {
        $array = [1,2,3,4,5];
        $actual = Workflow::create($array)->map(Sort\shuffle())->get();
        $this->assertNotEquals($array, $actual);
    }

    public function testSort()
    {
        $array = ['3a', '3b', '3c'];
        $actual = Workflow::create($array)->map(Sort\sort())->get();
        $this->assertEquals($array, $actual);
    }

    public function testSort_flags()
    {
        $array = ['3c', '3a', '3b'];
        $flag = SORT_NUMERIC;
        $actual = Workflow::create($array)->map(Sort\sort($flag))->get();
        $this->assertEquals($array, $actual);
    }

    public function testUasort()
    {
        $array = [1,2,3];
        $sort = function ($a, $b) {
            return $a <=> $b;
        };
        $actual = Workflow::create($array)->map(Sort\uasort($sort))->get();
        $this->assertEquals($array, $actual);
    }

    public function testUksort()
    {
        $array = [1,2,3];
        $sort = function ($a, $b) {
            return $a <=> $b;
        };
        $actual = Workflow::create($array)->map(Sort\uksort($sort))->get();
        $this->assertEquals($array, $actual);
    }

    public function testUsort()
    {
        $array = [1,2,3];
        $sort = function ($a, $b) {
            return $a <=> $b;
        };
        $actual = Workflow::create($array)->map(Sort\usort($sort))->get();
        $this->assertEquals($array, $actual);
    }
}