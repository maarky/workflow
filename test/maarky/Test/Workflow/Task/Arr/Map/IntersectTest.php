<?php
declare(strict_types=1);

namespace maarky\Test\Workflow\Task\Arr\Map;

use maarky\Workflow\Task\Arr\Map\Intersect;
use maarky\Workflow\Workflow;
use PHPUnit\Framework\TestCase;
use maarky\Workflow\Task\Utility;

class IntersectTest extends TestCase
{
    protected $errorReporting;
    protected $tasks;
    protected $tasksWarning;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->errorReporting = error_reporting();
        $this->tasks = new class {
            use Intersect, Utility;
        };
        $this->tasksWarning = new class {
            use Intersect, Utility;
            protected $throwWarnings = true;
        };
        parent::__construct($name , $data, $dataName);
    }

    public function tearDown()
    {
        error_reporting($this->errorReporting);
    }

    public function assocData()
    {
        $array1 = ["a" => "green", "b" => "brown", "c" => "blue", "red"];
        $array2 = ["a" => "green", "b" => "yellow", "blue", "red"];
        return [
            ['intersect assoc: default usage', E_ALL, array_intersect_assoc($array1, $array2), function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasks->intersectAssoc($array2))->get(); }],
            ['intersect assoc: not array 1 - error', E_ALL, true, function() use ($array1, $array2) { return Workflow::new(1)->map($this->tasks->intersectAssoc($array2))->isError(); }],
            ['intersect assoc: not array 2 - error', E_ALL, true, function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasks->intersectAssoc(1))->isError(); }],
            ['intersect assoc: not array 1 - no error', 0, false, function() use ($array1, $array2) { return Workflow::new(1)->map($this->tasks->intersectAssoc($array2))->isError(); }],
            ['intersect assoc: not array 1 - no error - throw', 0, true, function() use ($array1, $array2) { return Workflow::new(1)->map($this->tasksWarning->intersectAssoc($array2))->isError(); }],
            ['intersect assoc: not array 2 - no error', 0, false, function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasks->intersectAssoc(1))->isError(); }],
            ['intersect assoc: not array 2 - no error - throw', 0, true, function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasksWarning->intersectAssoc(1))->isError(); }],
            ['intersect assoc: not array 1 - empty', 0, true, function() use ($array1, $array2) { return Workflow::new(1)->map($this->tasks->intersectAssoc($array2))->isEmpty(); }],
            ['intersect assoc: not array 2 - empty', 0, true, function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasks->intersectAssoc(1))->isEmpty(); }]
        ];
    }

    public function keyData()
    {
        $array1 = ['blue'  => 1, 'red'  => 2, 'green'  => 3, 'purple' => 4];
        $array2 = ['green' => 5, 'blue' => 6, 'yellow' => 7, 'cyan'   => 8];
        return [
            ['intersect key: default usage', E_ALL, array_intersect_key($array1, $array2), function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasks->intersectKey($array2))->get(); }],
            ['intersect key: not array 1 - error', E_ALL, true, function() use ($array1, $array2) { return Workflow::new(1)->map($this->tasks->intersectKey($array2))->isError(); }],
            ['intersect key: not array 2 - error', E_ALL, true, function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasks->intersectKey(1))->isError(); }],
            ['intersect key: not array 1 - no error', 0, false, function() use ($array1, $array2) { return Workflow::new(1)->map($this->tasks->intersectKey($array2))->isError(); }],
            ['intersect key: not array 1 - no error - throw', 0, true, function() use ($array1, $array2) { return Workflow::new(1)->map($this->tasksWarning->intersectKey($array2))->isError(); }],
            ['intersect key: not array 2 - no error', 0, false, function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasks->intersectKey(1))->isError(); }],
            ['intersect key: not array 2 - no error - throw', 0, true, function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasksWarning->intersectKey(1))->isError(); }],
            ['intersect key: not array 1 - empty', 0, true, function() use ($array1, $array2) { return Workflow::new(1)->map($this->tasks->intersectKey($array2))->isEmpty(); }],
            ['intersect key: not array 2 - empty', 0, true, function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasks->intersectKey(1))->isEmpty(); }]
        ];
    }

    public function uassocData()
    {
        $array1 = ["a" => "green", "b" => "brown", "c" => "blue", "red"];
        $array2 = ["a" => "GREEN", "B" => "brown", "yellow", "red"];
        $keyCompare = function($a, $b) {
            return $a <=> $b;
        };
        return [
            ['intersect uassoc: default usage', E_ALL, array_intersect_uassoc($array1, $array2, $keyCompare), function() use ($array1, $array2, $keyCompare) { return Workflow::new($array1)->map($this->tasks->intersectUassoc($keyCompare, $array2))->get(); }],
            ['intersect uassoc: not array 1 - error', E_ALL, true, function() use ($array1, $array2, $keyCompare) { return Workflow::new(1)->map($this->tasks->intersectUassoc($keyCompare, $array2))->isError(); }],
            ['intersect uassoc: not array 2 - error', E_ALL, true, function() use ($array1, $array2, $keyCompare) { return Workflow::new($array1)->map($this->tasks->intersectUassoc($keyCompare, 1))->isError(); }],
            ['intersect uassoc: not array 1 - no error', 0, false, function() use ($array1, $array2, $keyCompare) { return Workflow::new(1)->map($this->tasks->intersectUassoc($keyCompare, $array2))->isError(); }],
            ['intersect uassoc: not array 1 - no error - throw', 0, true, function() use ($array1, $array2, $keyCompare) { return Workflow::new(1)->map($this->tasksWarning->intersectUassoc($keyCompare, $array2))->isError(); }],
            ['intersect uassoc: not array 2 - no error', 0, false, function() use ($array1, $array2, $keyCompare) { return Workflow::new($array1)->map($this->tasks->intersectUassoc($keyCompare, 1))->isError(); }],
            ['intersect uassoc: not array 2 - no error - throw', 0, true, function() use ($array1, $array2, $keyCompare) { return Workflow::new($array1)->map($this->tasksWarning->intersectUassoc($keyCompare, 1))->isError(); }],
            ['intersect uassoc: not array 1 - empty', 0, true, function() use ($array1, $array2, $keyCompare) { return Workflow::new(1)->map($this->tasks->intersectUassoc($keyCompare, $array2))->isEmpty(); }],
            ['intersect uassoc: not array 2 - empty', 0, true, function() use ($array1, $array2, $keyCompare) { return Workflow::new($array1)->map($this->tasks->intersectUassoc($keyCompare, 1))->isEmpty(); }]
        ];
    }

    public function ukeyData()
    {
        $array1 = ['blue'  => 1, 'red'  => 2, 'green'  => 3, 'purple' => 4];
        $array2 = ['green' => 5, 'blue' => 6, 'yellow' => 7, 'cyan'   => 8];
        $keyCompare = function($a, $b) {
            return $a <=> $b;
        };
        return [
            ['intersect ukey: default usage', E_ALL, array_intersect_ukey($array1, $array2, $keyCompare), function() use ($array1, $array2, $keyCompare) { return Workflow::new($array1)->map($this->tasks->intersectUkey($keyCompare, $array2))->get(); }],
            ['intersect ukey: not array 1 - error', E_ALL, true, function() use ($array1, $array2, $keyCompare) { return Workflow::new(1)->map($this->tasks->intersectUkey($keyCompare, $array2))->isError(); }],
            ['intersect ukey: not array 2 - error', E_ALL, true, function() use ($array1, $array2, $keyCompare) { return Workflow::new($array1)->map($this->tasks->intersectUkey($keyCompare, 1))->isError(); }],
            ['intersect ukey: not array 1 - no error', 0, false, function() use ($array1, $array2, $keyCompare) { return Workflow::new(1)->map($this->tasks->intersectUkey($keyCompare, $array2))->isError(); }],
            ['intersect ukey: not array 1 - no error - throw', 0, true, function() use ($array1, $array2, $keyCompare) { return Workflow::new(1)->map($this->tasksWarning->intersectUkey($keyCompare, $array2))->isError(); }],
            ['intersect ukey: not array 2 - no error', 0, false, function() use ($array1, $array2, $keyCompare) { return Workflow::new($array1)->map($this->tasks->intersectUkey($keyCompare, 1))->isError(); }],
            ['intersect ukey: not array 2 - no error - throw', 0, true, function() use ($array1, $array2, $keyCompare) { return Workflow::new($array1)->map($this->tasksWarning->intersectUkey($keyCompare, 1))->isError(); }],
            ['intersect ukey: not array 1 - empty', 0, true, function() use ($array1, $array2, $keyCompare) { return Workflow::new(1)->map($this->tasks->intersectUkey($keyCompare, $array2))->isEmpty(); }],
            ['intersect ukey: not array 2 - empty', 0, true, function() use ($array1, $array2, $keyCompare) { return Workflow::new($array1)->map($this->tasks->intersectUkey($keyCompare, 1))->isEmpty(); }]
        ];
    }

    public function intersectData()
    {
        $array1 = ["a" => "green", "red", "blue"];
        $array2 = ["b" => "green", "yellow", "red"];
        return [
            ['intersect: default usage', E_ALL, array_intersect($array1, $array2), function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasks->intersect($array2))->get(); }],
            ['intersect: not array 1 - error', E_ALL, true, function() use ($array1, $array2) { return Workflow::new(1)->map($this->tasks->intersect($array2))->isError(); }],
            ['intersect: not array 2 - error', E_ALL, true, function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasks->intersect(1))->isError(); }],
            ['intersect: not array 1 - no error', 0, false, function() use ($array1, $array2) { return Workflow::new(1)->map($this->tasks->intersect($array2))->isError(); }],
            ['intersect: not array 1 - no error throw', 0, true, function() use ($array1, $array2) { return Workflow::new(1)->map($this->tasksWarning->intersect($array2))->isError(); }],
            ['intersect: not array 2 - no error', 0, false, function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasks->intersect(1))->isError(); }],
            ['intersect: not array 2 - no error - throw', 0, true, function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasksWarning->intersect(1))->isError(); }],
            ['intersect: not array 1 - empty', 0, true, function() use ($array1, $array2) { return Workflow::new(1)->map($this->tasks->intersect($array2))->isEmpty(); }],
            ['intersect: not array 2 - empty', 0, true, function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasks->intersect(1))->isEmpty(); }]
        ];
    }

    /**
     * @dataProvider assocData
     * @dataProvider keyData
     * @dataProvider uassocData
     * @dataProvider ukeyData
     * @dataProvider intersectData
     */
    public function testIntersect($message, $errorReporting, $expected, $actual)
    {
        error_reporting($errorReporting);
        $this->assertSame($expected, $actual(), $message);
    }
}