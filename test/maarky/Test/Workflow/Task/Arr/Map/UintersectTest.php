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
