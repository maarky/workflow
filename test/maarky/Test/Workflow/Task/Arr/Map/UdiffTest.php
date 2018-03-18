<?php
declare(strict_types=1);

namespace maarky\Test\Workflow\Task\Arr\Map;

use maarky\Workflow\Task\Arr\Map\Udiff;
use maarky\Workflow\Workflow;
use PHPUnit\Framework\TestCase;
use maarky\Workflow\Task\Utility;

class UdiffTest extends TestCase
{
    protected $tasks;

    public function setUp()
    {
        $this->tasks = new class {
            use Udiff, Utility;
        };
    }

    public function testAssoc()
    {
        $array1 = ["0.1" => new cr(9), "0.5" => new cr(12), 0 => new cr(23), 1=> new cr(4), 2 => new cr(-15)];
        $array2 = ["0.2" => new cr(9), "0.5" => new cr(22), 0 => new cr(3), 1=> new cr(4), 2 => new cr(-15)];
        $callback = [cr::class, "comp_func_cr"];
        $expected = array_udiff_assoc($array1, $array2, $callback);
        $actual = Workflow::new($array1)->map($this->tasks->udiffAssoc($callback, $array2))->get();
        $this->assertSame($expected, $actual);
    }

    public function testAssoc_notArray()
    {
        $array2 = ["0.2" => new cr(9), "0.5" => new cr(22), 0 => new cr(3), 1=> new cr(4), 2 => new cr(-15)];
        $callback = [cr::class, "comp_func_cr"];
        $actual = Workflow::new(1)->map($this->tasks->udiffAssoc($callback, $array2))->isError();
        $this->assertTrue($actual);
    }

    public function testUassoc()
    {
        $array1 = ["0.1" => new cr(9), "0.5" => new cr(12), 0 => new cr(23), 1=> new cr(4), 2 => new cr(-15)];
        $array2 = ["0.2" => new cr(9), "0.5" => new cr(22), 0 => new cr(3), 1=> new cr(4), 2 => new cr(-15)];
        $valCompare = [cr::class, "comp_func_cr"];
        $keyCompare = [cr::class, "comp_func_key"];
        $expected = array_udiff_uassoc($array1, $array2, $valCompare, $keyCompare);
        $actual = Workflow::new($array1)->map($this->tasks->udiffUassoc($valCompare, $keyCompare, $array2))->get();
        $this->assertSame($expected, $actual);
    }

    public function testUassoc_notArray()
    {
        $array2 = ["0.2" => new cr(9), "0.5" => new cr(22), 0 => new cr(3), 1=> new cr(4), 2 => new cr(-15)];
        $valCompare = [cr::class, "comp_func_cr"];
        $keyCompare = [cr::class, "comp_func_key"];
        $actual = Workflow::new(1)->map($this->tasks->udiffUassoc($valCompare, $keyCompare, $array2))->isError();
        $this->assertTrue($actual);
    }

    public function testUdiff()
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
        $expected = array_udiff($array1, $array2, $compare);
        $actual = Workflow::new($array1)->map($this->tasks->udiff($compare, $array2))->get();
        $this->assertSame($expected, $actual);
        return [$compare, $array2];
    }

    /**
     * @depends testUdiff
     */
    public function testUdiff_notArray($data)
    {
        $actual = Workflow::new(1)->map($this->tasks->udiff($data[0], $data[1]))->isError();
        $this->assertTrue($actual);
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