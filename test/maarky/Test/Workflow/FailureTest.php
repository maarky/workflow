<?php


namespace maarky\Test\Workflow;

use maarky\Workflow\Error;
use maarky\Workflow\Workflow;
use PHPUnit\Framework\TestCase;


class FailureTest extends TestCase
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

    protected function getError()
    {
        return new class implements Error {};
    }

    public function testGet()
    {
        $this->expectException(\TypeError::class);
        Workflow::new($this->getError())->get();
    }

    public function testGetOrElse()
    {
        $value = 1;
        $this->assertEquals($value, Workflow::new($this->getError())->getOrElse($value));
    }

    public function testGetOrElse_invalidElse()
    {
        $this->expectException(\TypeError::class);
        Workflow::new($this->getError())->getOrElse(null);
    }

    public function testGetOrCall()
    {
        $value = 1;
        $call = function () use($value) {
            return $value;
        };
        $this->assertEquals($value, Workflow::new($this->getError())->getOrCall($call));
    }

    public function testGetOrCall_invalidElse()
    {
        $this->expectException(\TypeError::class);
        $call = function () {
            return null;
        };
        Workflow::new($this->getError())->getOrCall($call);
    }

    public function testOrElse()
    {
        $workflow = Workflow::new(1);
        $this->assertSame($workflow, Workflow::new($this->getError())->orElse($workflow));
    }

    public function testOrCall()
    {
        $workflow = Workflow::new(1);
        $call = function () use($workflow) {
            return $workflow;
        };
        $this->assertSame($workflow, Workflow::new($this->getError())->orCall($call));
    }

    public function testOrCall_badType()
    {
        $this->expectException(\TypeError::class);
        $workflow = Workflow::new(1);
        $call = function () use($workflow) {
            return null;
        };
        Workflow::new($this->getError())->orCall($call);
    }

    public function testIsDefined()
    {
        $this->assertFalse(Workflow::new($this->getError())->isDefined());
    }

    public function testIsEmpty()
    {
        $this->assertTrue(Workflow::new($this->getError())->isEmpty());
    }

    public function testFilter()
    {
        $workflow = Workflow::new($this->getError());
        $this->assertSame($workflow, $workflow->filter('strtolower'));
    }

    public function testFilter_functionNotCalled()
    {
        $workflow = Workflow::new($this->getError());
        $tracker = $this->getTracker();
        $workflow->filter($tracker);
        $this->assertFalse($tracker->wasUsed());
    }

    public function testFilterNot()
    {
        $workflow = Workflow::new($this->getError());
        $this->assertSame($workflow, $workflow->filterNot('strtolower'));
    }

    public function testFilterNot_functionNotCalled()
    {
        $workflow = Workflow::new($this->getError());
        $tracker = $this->getTracker();
        $workflow->filterNot($tracker);
        $this->assertFalse($tracker->wasUsed());
    }

    public function testForeach()
    {
        $workflow = Workflow::new($this->getError());
        $this->assertSame($workflow, $workflow->foreach('strtolower'));
    }

    public function testForeach_functionNotCalled()
    {
        $workflow = Workflow::new($this->getError());
        $tracker = $this->getTracker();
        $workflow->foreach($tracker);
        $this->assertFalse($tracker->wasUsed());
    }

    public function testFornothing()
    {
        $workflow = Workflow::new($this->getError());
        $this->assertSame($workflow, $workflow->fornothing($this->getTracker()));
    }

    public function testFornothing_functionWasCalled()
    {
        $workflow = Workflow::new($this->getError());
        $tracker = $this->getTracker();
        $workflow->fornothing($tracker);
        $this->assertTrue($tracker->wasUsed());
    }

    public function testIsError()
    {
        $this->assertTrue(Workflow::new($this->getError())->isError());
    }

    public function testEquals()
    {
        $error = $this->getError();
        $workflow1 = Workflow::new($error);
        $workflow2 = Workflow::new($error);
        $this->assertTrue($workflow1->equals($workflow2));
    }

    public function testEquals_false_error()
    {
        $workflow1 = Workflow::new($this->getError());
        $workflow2 = Workflow::new(null);
        $this->assertFalse($workflow1->equals($workflow2));
    }

    public function testEquals_false_success()
    {
        $workflow1 = Workflow::new($this->getError());
        $workflow2 = Workflow::new(1);
        $this->assertFalse($workflow1->equals($workflow2));
    }
}