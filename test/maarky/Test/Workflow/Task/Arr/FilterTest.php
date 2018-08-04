<?php
declare(strict_types=1);

namespace maarky\Test\Workflow\Task\Arr;

use maarky\Workflow\Task\Arr\Filter;
use maarky\Workflow\Workflow;
use PHPUnit\Framework\TestCase;

class FilterTest extends TestCase
{
    protected $tasks;

    public function testKeyExists()
    {
        $workflow = Workflow::create(['a' => 1])->filter(Filter\array_key_exists('a'));
        $this->assertTrue($workflow->isDefined());
    }

    public function testKeyExists_notFound_empty()
    {
        $workflow = Workflow::create(['a' => 1])->filter(Filter\array_key_exists('b'));
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
        $workflow = Workflow::create(['a' => 1])->filter(Filter\array_key_exists(new \stdClass()));
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

    public function testWalkRecursive()
    {
        $array = [1,2,3,4,5, [6,7,8,9,0]];
        $callback = function ($input) {
            //do nothing
        };
        $workflow = Workflow::create($array)->filter(Filter\array_walk_recursive($callback));
        $this->assertTrue($workflow->isDefined());
    }

    public function testWalkRecursive_foreach()
    {
        $array = [1,2,3,4,5, [6,7,8,9,0]];
        $callback = function ($input) {
            echo "$input\n";
        };
        ob_start();
        array_walk_recursive($array, $callback);
        $expected = ob_get_clean();
        ob_start();
        Workflow::create($array)->foreach(Filter\array_walk_recursive($callback));
        $actual = ob_get_clean();
        $this->assertEquals($expected, $actual);
    }

    public function testWalk()
    {
        $array = [1,2,3,4,5];
        $callback = function ($input) {
            //do nothing
        };
        $workflow = Workflow::create($array)->filter(Filter\array_walk($callback));
        $this->assertTrue($workflow->isDefined());
    }

    public function testWalk_foreach()
    {
        $array = [1,2,3,4,5];
        $callback = function ($input) {
            echo "$input\n";
        };
        ob_start();
        array_walk($array, $callback);
        $expected = ob_get_clean();
        ob_start();
        Workflow::create($array)->foreach(Filter\array_walk($callback));
        $actual = ob_get_clean();
        $this->assertEquals($expected, $actual);
    }

    public function testCount_true()
    {
        $array = [1,2,3,4,5];
        $actual = Workflow::create($array)->filter(Filter\count());
        $this->assertTrue($actual->isDefined());
    }

    public function testCount_false()
    {
        $array = [];
        $actual = Workflow::create($array)->filter(Filter\count());
        $this->assertTrue($actual->isEmpty());
    }

    public function testInArray_true()
    {
        $array = [1,2,3,4,5];
        $actual = Workflow::create($array)->filter(Filter\in_array(1));
        $this->assertTrue($actual->isDefined());
    }

    public function testInArray_notStrict_true()
    {
        $array = [1,2,3,4,5];
        $actual = Workflow::create($array)->filter(Filter\in_array('1'));
        $this->assertTrue($actual->isDefined());
    }

    public function testInArray_false()
    {
        $array = [1,2,3,4,5];
        $actual = Workflow::create($array)->filter(Filter\in_array(11));
        $this->assertTrue($actual->isEmpty());
    }

    public function testInArray_strict_true()
    {
        $array = [1, 2, 3, 4, 5];
        $actual = Workflow::create($array)->filter(Filter\in_array(1, true));
        $this->assertTrue($actual->isDefined());
    }

    public function testInArray_strict_false()
    {
        $array = [1,2,3,4,5];
        $actual = Workflow::create($array)->filter(Filter\in_array('1', true));
        $this->assertTrue($actual->isEmpty());
    }
}