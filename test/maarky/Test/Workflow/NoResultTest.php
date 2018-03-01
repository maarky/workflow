<?php


namespace maarky\Test\Workflow;

use maarky\Workflow\Error;
use maarky\Workflow\Workflow;
use PHPUnit\Framework\TestCase;


class NoResultTest extends TestCase
{
    public function getTracker()
    {
        return new class {
            public $used = false;

            public function didUse()
            {
                $this->used = true;
            }

            public function wasUsed()
            {
                return $this->used;
            }

            public function __invoke()
            {
                $this->didUse();
            }
        };
    }

    public function testGet()
    {
        $this->expectException(\TypeError::class);
        Workflow::new(null)->get();
    }

    public function testGetOrElse()
    {
        $value = 1;
        $this->assertEquals($value, Workflow::new(null)->getOrElse($value));
    }

    public function testGetOrElse_invalidElse()
    {
        $this->expectException(\TypeError::class);
        Workflow::new(null)->getOrElse(null);
    }

    public function testGetOrCall()
    {
        $value = 1;
        $call = function () use($value) {
            return $value;
        };
        $this->assertEquals($value, Workflow::new(null)->getOrCall($call));
    }

    public function testGetOrCall_invalidElse()
    {
        $this->expectException(\TypeError::class);
        $call = function () {
            return null;
        };
        Workflow::new(null)->getOrCall($call);
    }

    public function testOrElse()
    {
        $workflow = Workflow::new(1);
        $this->assertSame($workflow, Workflow::new(null)->orElse($workflow));
    }

    public function testOrCall()
    {
        $workflow = Workflow::new(1);
        $call = function () use($workflow) {
            return $workflow;
        };
        $this->assertSame($workflow, Workflow::new(null)->orCall($call));
    }

    public function testOrCall_badType()
    {
        $this->expectException(\TypeError::class);
        $workflow = Workflow::new(1);
        $call = function () use($workflow) {
            return null;
        };
        Workflow::new(null)->orCall($call);
    }

    public function testIsDefined()
    {
        $this->assertFalse(Workflow::new(null)->isDefined());
    }

    public function testIsEmpty()
    {
        $this->assertTrue(Workflow::new(null)->isEmpty());
    }

    public function testFilter()
    {
        $workflow = Workflow::new(null);
        $this->assertSame($workflow, $workflow->filter('strtolower'));
    }

    public function testFilter_functionNotCalled()
    {
        $workflow = Workflow::new(null);
        $tracker = $this->getTracker();
        $workflow->filter($tracker);
        $this->assertFalse($tracker->wasUsed());
    }

    public function testFilterNot()
    {
        $workflow = Workflow::new(null);
        $this->assertSame($workflow, $workflow->filterNot('strtolower'));
    }

    public function testFilterNot_functionNotCalled()
    {
        $workflow = Workflow::new(null);
        $tracker = $this->getTracker();
        $workflow->filterNot($tracker);
        $this->assertFalse($tracker->wasUsed());
    }

    public function testForeach()
    {
        $workflow = Workflow::new(null);
        $this->assertSame($workflow, $workflow->foreach('strtolower'));
    }

    public function testForeach_functionNotCalled()
    {
        $workflow = Workflow::new(null);
        $tracker = $this->getTracker();
        $workflow->foreach($tracker);
        $this->assertFalse($tracker->wasUsed());
    }

    public function testFornothing()
    {
        $workflow = Workflow::new(null);
        $this->assertSame($workflow, $workflow->fornothing($this->getTracker()));
    }

    public function testFornothing_functionWasCalled()
    {
        $workflow = Workflow::new(null);
        $tracker = $this->getTracker();
        $workflow->fornothing($tracker);
        $this->assertTrue($tracker->wasUsed());
    }

    public function testIsError()
    {
        $this->assertFalse(Workflow::new(null)->isError());
    }

    public function testEquals()
    {
        $workflow1 = Workflow::new(null);
        $workflow2 = Workflow::new(null);
        $this->assertTrue($workflow1->equals($workflow2));
    }

    public function testEquals_false_error()
    {
        $workflow1 = Workflow::new(null);
        $workflow2 = Workflow::new(new class implements Error{});
        $this->assertFalse($workflow1->equals($workflow2));
    }

    public function testEquals_false_success()
    {
        $workflow1 = Workflow::new(null);
        $workflow2 = Workflow::new(1);
        $this->assertFalse($workflow1->equals($workflow2));
    }

    public function testGetError()
    {
        $this->assertFalse(Workflow::new(1)->getError()->isDefined());
    }
}