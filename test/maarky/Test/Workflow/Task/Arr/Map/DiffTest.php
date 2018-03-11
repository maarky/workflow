<?php
declare(strict_types=1);

namespace maarky\Test\Workflow\Task\Arr\Map;

use maarky\Workflow\Task\Arr\Map\Diff;
use maarky\Workflow\Workflow;
use PHPUnit\Framework\TestCase;
use maarky\Workflow\Task\Utility;

class DiffTest extends TestCase
{
    protected $errorReporting;
    protected $tasks;
    protected $tasksWarning;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->errorReporting = error_reporting();
        $this->tasks = new class {
            use Diff, Utility;
        };
        $this->tasksWarning = new class {
            use Diff, Utility;
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
        $array2 = ["a" => "green", "yellow", "red"];
        return [
            ['assoc: default usage', E_ALL, array_diff_assoc($array1, $array2), function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasks->diffAssoc($array2))->get(); }],
            ['assoc: not array 1 - error', E_ALL, true, function() use ($array1, $array2) { return Workflow::new(1)->map($this->tasks->diffAssoc($array2))->isError(); }],
            ['assoc: not array 2 - error', E_ALL, true, function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasks->diffAssoc(1))->isError(); }],
            ['assoc: not array 1 - no error', 0, false, function() use ($array1, $array2) { return Workflow::new(1)->map($this->tasks->diffAssoc($array2))->isError(); }],
            ['assoc: not array 1 - no error - throw', 0, true, function() use ($array1, $array2) { return Workflow::new(1)->map($this->tasksWarning->diffAssoc($array2))->isError(); }],
            ['assoc: not array 2 - no error', 0, false, function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasks->diffAssoc(1))->isError(); }],
            ['assoc: not array 2 - no error - throw', 0, true, function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasksWarning->diffAssoc(1))->isError(); }],
            ['assoc: not array 1 - empty', 0, true, function() use ($array1, $array2) { return Workflow::new(1)->map($this->tasks->diffAssoc($array2))->isEmpty(); }],
            ['assoc: not array 2 - empty', 0, true, function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasks->diffAssoc(1))->isEmpty(); }]
        ];
    }

    public function keyData()
    {
        $array1 = ['blue' => 1, 'red' => 2, 'green' => 3, 'purple' => 4];
        $array2 = ['green' => 5, 'yellow' => 7, 'cyan' => 8];
        return [
            ['key: default usage', E_ALL, array_diff_key($array1, $array2), function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasks->diffKey($array2))->get(); }],
            ['key: not array 1 - error', E_ALL, true, function() use ($array1, $array2) { return Workflow::new(1)->map($this->tasks->diffKey($array2))->isError(); }],
            ['key: not array 2 - error', E_ALL, true, function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasks->diffKey(1))->isError(); }],
            ['key: not array 1 - no error', 0, false, function() use ($array1, $array2) { return Workflow::new(1)->map($this->tasks->diffKey($array2))->isError(); }],
            ['key: not array 1 - no error - throw', 0, true, function() use ($array1, $array2) { return Workflow::new(1)->map($this->tasksWarning->diffKey($array2))->isError(); }],
            ['key: not array 2 - no error', 0, false, function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasks->diffKey(1))->isError(); }],
            ['key: not array 2 - no error - throw', 0, true, function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasksWarning->diffKey(1))->isError(); }],
            ['key: not array 1 - empty', 0, true, function() use ($array1, $array2) { return Workflow::new(1)->map($this->tasks->diffKey($array2))->isEmpty(); }],
            ['key: not array 2 - empty', 0, true, function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasks->diffKey(1))->isEmpty(); }]
        ];
    }

    public function uassocData()
    {
        $array1 = ["a" => "green", "b" => "brown", "c" => "blue", "red"];
        $array2 = ["a" => "green", "yellow", "red"];
        $keyCompare = function($a, $b) {
            return $a <=> $b;
        };
        return [
            ['uassoc: default usage', E_ALL, array_diff_uassoc($array1, $array2, $keyCompare), function() use ($array1, $array2, $keyCompare) { return Workflow::new($array1)->map($this->tasks->diffUassoc($keyCompare, $array2))->get(); }],
            ['uassoc: not array 1 - error', E_ALL, true, function() use ($array1, $array2, $keyCompare) { return Workflow::new(1)->map($this->tasks->diffUassoc($keyCompare, $array2))->isError(); }],
            ['uassoc: not array 2 - error', E_ALL, true, function() use ($array1, $array2, $keyCompare) { return Workflow::new($array1)->map($this->tasks->diffUassoc($keyCompare, 1))->isError(); }],
            ['uassoc: not array 1 - no error', 0, false, function() use ($array1, $array2, $keyCompare) { return Workflow::new(1)->map($this->tasks->diffUassoc($keyCompare, $array2))->isError(); }],
            ['uassoc: not array 1 - no error - throw', 0, true, function() use ($array1, $array2, $keyCompare) { return Workflow::new(1)->map($this->tasksWarning->diffUassoc($keyCompare, $array2))->isError(); }],
            ['uassoc: not array 2 - no error', 0, false, function() use ($array1, $array2, $keyCompare) { return Workflow::new($array1)->map($this->tasks->diffUassoc($keyCompare, 1))->isError(); }],
            ['uassoc: not array 2 - no error - throw', 0, true, function() use ($array1, $array2, $keyCompare) { return Workflow::new($array1)->map($this->tasksWarning->diffUassoc($keyCompare, 1))->isError(); }],
            ['uassoc: not array 1 - empty', 0, true, function() use ($array1, $array2, $keyCompare) { return Workflow::new(1)->map($this->tasks->diffUassoc($keyCompare, $array2))->isEmpty(); }],
            ['uassoc: not array 2 - empty', 0, true, function() use ($array1, $array2, $keyCompare) { return Workflow::new($array1)->map($this->tasks->diffUassoc($keyCompare, 1))->isEmpty(); }]
        ];
    }

    public function ukeyData()
    {
        $array1 = ['blue' => 1, 'red' => 2, 'green' => 3, 'purple' => 4];
        $array2 = ['green' => 5, 'yellow' => 7, 'cyan' => 8];
        $keyCompare = function($a, $b) {
            return $a <=> $b;
        };
        return [
            ['ukey: default usage', E_ALL, array_diff_ukey($array1, $array2, $keyCompare), function() use ($array1, $array2, $keyCompare) { return Workflow::new($array1)->map($this->tasks->diffUkey($keyCompare, $array2))->get(); }],
            ['ukey: not array 1 - error', E_ALL, true, function() use ($array1, $array2, $keyCompare) { return Workflow::new(1)->map($this->tasks->diffUkey($keyCompare, $array2))->isError(); }],
            ['ukey: not array 2 - error', E_ALL, true, function() use ($array1, $array2, $keyCompare) { return Workflow::new($array1)->map($this->tasks->diffUkey($keyCompare, 1))->isError(); }],
            ['ukey: not array 1 - no error', 0, false, function() use ($array1, $array2, $keyCompare) { return Workflow::new(1)->map($this->tasks->diffUkey($keyCompare, $array2))->isError(); }],
            ['ukey: not array 1 - no error - throw', 0, true, function() use ($array1, $array2, $keyCompare) { return Workflow::new(1)->map($this->tasksWarning->diffUkey($keyCompare, $array2))->isError(); }],
            ['ukey: not array 2 - no error', 0, false, function() use ($array1, $array2, $keyCompare) { return Workflow::new($array1)->map($this->tasks->diffUkey($keyCompare, 1))->isError(); }],
            ['ukey: not array 2 - no error - throw', 0, true, function() use ($array1, $array2, $keyCompare) { return Workflow::new($array1)->map($this->tasksWarning->diffUkey($keyCompare, 1))->isError(); }],
            ['ukey: not array 1 - empty', 0, true, function() use ($array1, $array2, $keyCompare) { return Workflow::new(1)->map($this->tasks->diffUkey($keyCompare, $array2))->isEmpty(); }],
            ['ukey: not array 2 - empty', 0, true, function() use ($array1, $array2, $keyCompare) { return Workflow::new($array1)->map($this->tasks->diffUkey($keyCompare, 1))->isEmpty(); }]
        ];
    }

    public function diffData()
    {
        $array1 = ["a" => "green", "red", "blue", "red"];
        $array2 = ["b" => "green", "yellow", "red"];
        return [
            ['diff: default usage', E_ALL, array_diff($array1, $array2), function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasks->diff($array2))->get(); }],
            ['diff: not array 1 - error', E_ALL, true, function() use ($array1, $array2) { return Workflow::new(1)->map($this->tasks->diff($array2))->isError(); }],
            ['diff: not array 2 - error', E_ALL, true, function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasks->diff(1))->isError(); }],
            ['diff: not array 1 - no error', 0, false, function() use ($array1, $array2) { return Workflow::new(1)->map($this->tasks->diff($array2))->isError(); }],
            ['diff: not array 1 - no error throw', 0, true, function() use ($array1, $array2) { return Workflow::new(1)->map($this->tasksWarning->diff($array2))->isError(); }],
            ['diff: not array 2 - no error', 0, false, function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasks->diff(1))->isError(); }],
            ['diff: not array 2 - no error - throw', 0, true, function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasksWarning->diff(1))->isError(); }],
            ['diff: not array 1 - empty', 0, true, function() use ($array1, $array2) { return Workflow::new(1)->map($this->tasks->diff($array2))->isEmpty(); }],
            ['diff: not array 2 - empty', 0, true, function() use ($array1, $array2) { return Workflow::new($array1)->map($this->tasks->diff(1))->isEmpty(); }]
        ];
    }

    /**
     * @dataProvider assocData
     * @dataProvider keyData
     * @dataProvider uassocData
     * @dataProvider ukeyData
     * @dataProvider diffData
     */
    public function testDiff($message, $errorReporting, $expected, $actual)
    {
        error_reporting($errorReporting);
        $this->assertSame($expected, $actual(), $message);
    }
}