<?php
declare(strict_types=1);

namespace maarky\Test\Workflow\Task\Arr\Map;

use maarky\Workflow\Task\Arr\Map\Udiff;
use maarky\Workflow\Workflow;
use PHPUnit\Framework\TestCase;
use maarky\Workflow\Task\Utility;

class UdiffTest extends TestCase
{
    protected $errorReporting;
    protected $tasks;
    protected $tasksWarning;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->errorReporting = error_reporting();
        $this->tasks = new class {
            use Udiff, Utility;
        };
        $this->tasksWarning = new class {
            use Udiff, Utility;
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
        $array1 = ["0.1" => new cr(9), "0.5" => new cr(12), 0 => new cr(23), 1=> new cr(4), 2 => new cr(-15)];
        $array2 = ["0.2" => new cr(9), "0.5" => new cr(22), 0 => new cr(3), 1=> new cr(4), 2 => new cr(-15)];
        $callback = [cr::class, "comp_func_cr"];
        return [
            ['udiff assoc: default usage', E_ALL, array_udiff_assoc($array1, $array2, $callback), function() use ($array1, $array2, $callback) { return Workflow::new($array1)->map($this->tasks->udiffAssoc($callback, $array2))->get(); }],
            ['udiff assoc: not array 1 - error', E_ALL, true, function() use ($array1, $array2, $callback) { return Workflow::new(1)->map($this->tasks->udiffAssoc($callback, $array2))->isError(); }],
        ];
    }

    public function uassocData()
    {
        $array1 = ["0.1" => new cr(9), "0.5" => new cr(12), 0 => new cr(23), 1=> new cr(4), 2 => new cr(-15)];
        $array2 = ["0.2" => new cr(9), "0.5" => new cr(22), 0 => new cr(3), 1=> new cr(4), 2 => new cr(-15)];
        $valCompare = [cr::class, "comp_func_cr"];
        $keyCompare = [cr::class, "comp_func_key"];
        return [
            ['udiff uassoc: default usage', E_ALL, array_udiff_uassoc($array1, $array2, $valCompare, $keyCompare), function() use ($array1, $array2, $valCompare, $keyCompare) { return Workflow::new($array1)->map($this->tasks->udiffUassoc($valCompare, $keyCompare, $array2))->get(); }],
            ['udiff uassoc: not array 1 - error', E_ALL, true, function() use ($array1, $array2, $valCompare, $keyCompare) { return Workflow::new(1)->map($this->tasks->udiffUassoc($valCompare, $keyCompare, $array2))->isError(); }],
        ];
    }

    public function udiffData()
    {
        $array1 = [new \stdclass, new \stdclass, new \stdclass, new \stdclass];
        $array2 = [new \stdclass, new \stdclass];
        $array1[0]->width = 11; $array1[0]->height = 3;
        $array1[1]->width = 7;  $array1[1]->height = 1;
        $array1[2]->width = 2;  $array1[2]->height = 9;
        $array1[3]->width = 5;  $array1[3]->height = 7;
        $array2[0]->width = 7;  $array2[0]->height = 5;
        $array2[1]->width = 9;  $array2[1]->height = 2;
        $compare = function ($a, $b) {
            $areaA = $a->width * $a->height;
            $areaB = $b->width * $b->height;
            return $areaA <=> $areaB;
        };
        return [
            ['udiff: default usage', E_ALL, array_udiff($array1, $array2, $compare), function() use ($array1, $array2, $compare) { return Workflow::new($array1)->map($this->tasks->udiff($compare, $array2))->get(); }],
            ['udiff: not array 1 - error', E_ALL, true, function() use ($array1, $array2, $compare) { return Workflow::new(1)->map($this->tasks->udiff($compare, $array2))->isError(); }],
        ];
    }

    /**
     * @dataProvider assocData
     * @dataProvider uassocData
     * @dataProvider udiffData
     */
    public function testUdiff($message, $errorReporting, $expected, $actual)
    {
        error_reporting($errorReporting);
        $this->assertSame($expected, $actual(), $message);
    }
}

class cr {
    private $priv_member;
    function __construct($val)
    {
        $this->priv_member = $val;
    }

    static function comp_func_cr($a, $b)
    {
        return $a->priv_member <=> $b->priv_member;
    }

    static function comp_func_key($a, $b)
    {
        if ($a === $b) return 0;
        return ($a > $b)? 1:-1;
    }
}