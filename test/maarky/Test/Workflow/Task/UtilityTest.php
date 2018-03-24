<?php
declare(strict_types=1);

namespace maarky\Test\Workflow\Task;

use maarky\Workflow\Task\Arr\Map\Diff;
use maarky\Workflow\Workflow;
use PHPUnit\Framework\TestCase;
use maarky\Workflow\Task\Utility;

class UtilityTest extends TestCase
{
    protected $tasks;

    public function setUp()
    {
        $this->tasks = new class {
            use Utility;
        };
    }

    public function testBind()
    {
        $array = [1,2,3,4,5,6];
        $size = 2;
        $preserveKeys = true;
        $expected = array_chunk($array, $size, $preserveKeys);
        $actual = Workflow::new($array)->map($this->tasks->bind('array_chunk', [$size, $preserveKeys]))->get();
        $this->assertSame($expected, $actual);
    }

    public function testBindFlatmap()
    {
        $array = [1,2,3,4,5,6];
        $glue = '-';
        $expected = implode($glue, $array);
        $class = \maarky\Workflow\Type\String\Workflow::class;
        $actual = Workflow::new($array)->flatMap($this->tasks->bindFlatmap($class,'implode', [$glue]));
        $this->assertSame($expected, $actual->get());
        return [$class, $actual];
    }

    /**
     * @depends testBindFlatmap
     */
    public function testBindFlatmap_correctType($input)
    {
        $this->assertInstanceOf($input[0], $input[1]);
    }

    public function testBindFlatmap_empty()
    {
        $array = [1,2,3,4,5,6];
        $glue = '-';
        $class = \maarky\Workflow\Type\Int\Workflow::class;
        $actual = Workflow::new($array)->flatMap($this->tasks->bindFlatmap($class,'implode', [$glue, '?' => '']));
        $this->assertTrue($actual->isEmpty());
        return $actual;
    }

    /**
     * @depends testBindFlatmap_empty
     */
    public function testBindFlatmap_empty_notError(Workflow $workflow)
    {
        $this->assertFalse($workflow->isError());
    }
}