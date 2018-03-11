<?php
declare(strict_types=1);

namespace maarky\Test\Workflow\Task\Arr\Map;

use maarky\Workflow\Task\Arr\Map\Uintersect;
use maarky\Workflow\Workflow;
use PHPUnit\Framework\TestCase;
use maarky\Workflow\Task\Utility;

class UintersectTest extends TestCase
{
    protected $errorReporting;
    protected $tasks;
    protected $tasksWarning;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->errorReporting = error_reporting();
        $this->tasks = new class {
            use Uintersect, Utility;
        };
        $this->tasksWarning = new class {
            use Uintersect, Utility;
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
        $array2 = ["a" => "GREEN", "B" => "brown", "yellow", "red"];
        $callback = 'strcasecmp';
        return [
            ['uintersect assoc: default usage', E_ALL, array_uintersect_assoc($array1, $array2, $callback), function() use ($array1, $array2, $callback) { return Workflow::new($array1)->map($this->tasks->uintersectAssoc($callback, $array2))->get(); }],
            ['uintersect assoc: not array 1 - error', E_ALL, true, function() use ($array1, $array2, $callback) { return Workflow::new(1)->map($this->tasks->uintersectAssoc($callback, $array2))->isError(); }],
            ['uintersect assoc: not array 2 - error', E_ALL, true, function() use ($array1, $array2, $callback) { return Workflow::new($array1)->map($this->tasks->uintersectAssoc($callback, 1))->isError(); }],
            ['uintersect assoc: not callable - error', E_ALL, true, function() use ($array1, $array2, $callback) { return Workflow::new($array1)->map($this->tasks->uintersectAssoc(1, 1))->isError(); }],
            ['uintersect assoc: not array 1 - no error', 0, false, function() use ($array1, $array2, $callback) { return Workflow::new(1)->map($this->tasks->uintersectAssoc($callback, $array2))->isError(); }],
            ['uintersect assoc: not array 1 - no error - throw', 0, true, function() use ($array1, $array2, $callback) { return Workflow::new(1)->map($this->tasksWarning->uintersectAssoc($callback, $array2))->isError(); }],
            ['uintersect assoc: not array 2 - no error', 0, false, function() use ($array1, $array2, $callback) { return Workflow::new($array1)->map($this->tasks->uintersectAssoc($callback, 1))->isError(); }],
            ['uintersect assoc: not array 2 - no error - throw', 0, true, function() use ($array1, $array2, $callback) { return Workflow::new($array1)->map($this->tasksWarning->uintersectAssoc($callback, 1))->isError(); }],
            ['uintersect assoc: not callable - no error', 0, true, function() use ($array1, $array2, $callback) { return Workflow::new($array1)->map($this->tasks->uintersectAssoc(1, $array2))->isError(); }],
            ['uintersect assoc: not callable - no error - throw', 0, true, function() use ($array1, $array2, $callback) { return Workflow::new($array1)->map($this->tasksWarning->uintersectAssoc(1, $array2))->isError(); }],
            ['uintersect assoc: not array 1 - empty', 0, true, function() use ($array1, $array2, $callback) { return Workflow::new(1)->map($this->tasks->uintersectAssoc($callback, $array2))->isEmpty(); }],
            ['uintersect assoc: not array 2 - empty', 0, true, function() use ($array1, $array2, $callback) { return Workflow::new($array1)->map($this->tasks->uintersectAssoc($callback, 1))->isEmpty(); }]
        ];
    }

    public function uassocData()
    {
        $array1 = ["a" => "green", "b" => "brown", "c" => "blue", "red"];
        $array2 = ["a" => "GREEN", "B" => "brown", "yellow", "red"];
        $valCompare = 'strcasecmp';
        $keyCompare = 'strcasecmp';
        return [
            ['uintersect uassoc: default usage', E_ALL, array_uintersect_uassoc($array1, $array2, $valCompare, $keyCompare), function() use ($array1, $array2, $valCompare, $keyCompare) { return Workflow::new($array1)->map($this->tasks->uintersectUassoc($valCompare, $keyCompare, $array2))->get(); }],
            ['uintersect uassoc: not array 1 - error', E_ALL, true, function() use ($array1, $array2, $valCompare, $keyCompare) { return Workflow::new(1)->map($this->tasks->uintersectUassoc($valCompare, $keyCompare, $array2))->isError(); }],
            ['uintersect uassoc: not array 2 - error', E_ALL, true, function() use ($array1, $array2, $valCompare, $keyCompare) { return Workflow::new($array1)->map($this->tasks->uintersectUassoc($valCompare, $keyCompare, 1))->isError(); }],
            ['uintersect uassoc: not callback 1 - error', E_ALL, true, function() use ($array1, $array2, $valCompare, $keyCompare) { return Workflow::new($array1)->map($this->tasks->uintersectUassoc(1, $keyCompare, 1))->isError(); }],
            ['uintersect uassoc: not callback 2 - error', E_ALL, true, function() use ($array1, $array2, $valCompare, $keyCompare) { return Workflow::new($array1)->map($this->tasks->uintersectUassoc($valCompare, 1, 1))->isError(); }],
            ['uintersect uassoc: not array 1 - no error', 0, false, function() use ($array1, $array2, $valCompare, $keyCompare) { return Workflow::new(1)->map($this->tasks->uintersectUassoc($valCompare, $keyCompare, $array2))->isError(); }],
            ['uintersect uassoc: not array 1 - no error - throw', 0, true, function() use ($array1, $array2, $valCompare, $keyCompare) { return Workflow::new(1)->map($this->tasksWarning->uintersectUassoc($valCompare, $keyCompare, $array2))->isError(); }],
            ['uintersect uassoc: not callback 1 - no error', 0, true, function() use ($array1, $array2, $valCompare, $keyCompare) { return Workflow::new($array1)->map($this->tasks->uintersectUassoc(1, $keyCompare, 1))->isError(); }],
            ['uintersect uassoc: not callback 2 - no error', 0, true, function() use ($array1, $array2, $valCompare, $keyCompare) { return Workflow::new($array1)->map($this->tasks->uintersectUassoc($valCompare, 1, 1))->isError(); }],
            ['uintersect uassoc: not callback 1 - no error - throw', 0, true, function() use ($array1, $array2, $valCompare, $keyCompare) { return Workflow::new($array1)->map($this->tasksWarning->uintersectUassoc(1, $keyCompare, 1))->isError(); }],
            ['uintersect uassoc: not callback 2 - no error - throw', 0, true, function() use ($array1, $array2, $valCompare, $keyCompare) { return Workflow::new($array1)->map($this->tasksWarning->uintersectUassoc($valCompare, 1, 1))->isError(); }],
            ['uintersect uassoc: not array 2 - no error', 0, false, function() use ($array1, $array2, $valCompare, $keyCompare) { return Workflow::new($array1)->map($this->tasks->uintersectUassoc($valCompare, $keyCompare, 1))->isError(); }],
            ['uintersect uassoc: not array 2 - no error - throw', 0, true, function() use ($array1, $array2, $valCompare, $keyCompare) { return Workflow::new($array1)->map($this->tasksWarning->uintersectUassoc($valCompare, $keyCompare, 1))->isError(); }],
            ['uintersect uassoc: not array 1 - empty', 0, true, function() use ($array1, $array2, $valCompare, $keyCompare) { return Workflow::new(1)->map($this->tasks->uintersectUassoc($valCompare, $keyCompare, $array2))->isEmpty(); }],
            ['uintersect uassoc: not array 2 - empty', 0, true, function() use ($array1, $array2, $valCompare, $keyCompare) { return Workflow::new($array1)->map($this->tasks->uintersectUassoc($valCompare, $keyCompare, 1))->isEmpty(); }]
        ];
    }

    public function uintersectData()
    {
        $array1 = ["a" => "green", "b" => "brown", "c" => "blue", "red"];
        $array2 = ["a" => "GREEN", "B" => "brown", "yellow", "red"];
        $compare = 'strcasecmp';
        return [
            ['uintersect: default usage', E_ALL, array_uintersect($array1, $array2, $compare), function() use ($array1, $array2, $compare) { return Workflow::new($array1)->map($this->tasks->uintersect($compare, $array2))->get(); }],
            ['uintersect: not array 1 - error', E_ALL, true, function() use ($array1, $array2, $compare) { return Workflow::new(1)->map($this->tasks->uintersect($compare, $array2))->isError(); }],
            ['uintersect: not array 2 - error', E_ALL, true, function() use ($array1, $array2, $compare) { return Workflow::new($array1)->map($this->tasks->uintersect($compare, 1))->isError(); }],
            ['uintersect: not callable - error', E_ALL, true, function() use ($array1, $array2, $compare) { return Workflow::new($array1)->map($this->tasks->uintersect(1, $array2))->isError(); }],
            ['uintersect: not array 1 - no error', 0, false, function() use ($array1, $array2, $compare) { return Workflow::new(1)->map($this->tasks->uintersect($compare, $array2))->isError(); }],
            ['uintersect: not array 1 - no error throw', 0, true, function() use ($array1, $array2, $compare) { return Workflow::new(1)->map($this->tasksWarning->uintersect($compare, $array2))->isError(); }],
            ['uintersect: not array 2 - no error', 0, false, function() use ($array1, $array2, $compare) { return Workflow::new($array1)->map($this->tasks->uintersect($compare, 1))->isError(); }],
            ['uintersect: not array 2 - no error - throw', 0, true, function() use ($array1, $array2, $compare) { return Workflow::new($array1)->map($this->tasksWarning->uintersect($compare, 1))->isError(); }],
            ['uintersect: not callable - no error', 0, true, function() use ($array1, $array2, $compare) { return Workflow::new($array1)->map($this->tasks->uintersect(1, $array2))->isError(); }],
            ['uintersect: not callable - no error - throw', 0, true, function() use ($array1, $array2, $compare) { return Workflow::new($array1)->map($this->tasksWarning->uintersect(1, $array2))->isError(); }],
            ['uintersect: not array 1 - empty', 0, true, function() use ($array1, $array2, $compare) { return Workflow::new(1)->map($this->tasks->uintersect($compare, $array2))->isEmpty(); }],
            ['uintersect: not array 2 - empty', 0, true, function() use ($array1, $array2, $compare) { return Workflow::new($array1)->map($this->tasks->uintersect($compare, 1))->isEmpty(); }]
        ];
    }

    /**
     * @dataProvider assocData
     * @dataProvider uassocData
     * @dataProvider uintersectData
     */
    public function testUintersect($message, $errorReporting, $expected, $actual)
    {
        error_reporting($errorReporting);
        $this->assertSame($expected, $actual(), $message);
    }
}
