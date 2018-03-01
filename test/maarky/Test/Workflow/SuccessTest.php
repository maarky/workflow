<?php


namespace maarky\Test\Workflow;

use maarky\Workflow\Component\BaseSuccess;
use maarky\Workflow\Error;
use maarky\Workflow\Failure;
use maarky\Workflow\NoResult;
use maarky\Workflow\Success;
use maarky\Workflow\Workflow;
use PHPUnit\Framework\TestCase;


class SuccessTest extends TestCase
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
        };
    }

    public function testGet()
    {
        $value = 1;
        $workflow = Workflow::new($value);
        $this->assertSame($value, $workflow->get());
    }

    public function testGetOrElse()
    {
        $value = 1;
        $workflow = Workflow::new($value);
        $this->assertSame($value, $workflow->getOrElse($value + $value));
    }

    public function testGetOrCall()
    {
        $value = 1;
        $workflow = Workflow::new($value);
        $this->assertSame($value, $workflow->getOrCall('strtolower'));
    }

    public function testOrElse()
    {
        $workflow = Workflow::new(1);
        $this->assertSame($workflow, $workflow->orElse(Workflow::new(2)));
    }

    public function testOrCall()
    {
        $workflow = Workflow::new(1);
        $this->assertSame($workflow, $workflow->orCall('strtolower'));
    }

    public function testIsDefined()
    {
        $this->assertTrue(Workflow::new(1)->isDefined());
    }

    public function testIsEmpty()
    {
        $this->assertFalse(Workflow::new(1)->isEmpty());
    }

    public function testFilter_true()
    {
        $value = 1;
        $workflow = Workflow::new($value);
        $filter = function ($input) use ($value) {
            return $input === $value;
        };
        $this->assertInstanceOf(Success::class, $workflow->filter($filter));
    }

    public function testFilter_false()
    {
        $value = 1;
        $workflow = Workflow::new($value);
        $filter = function ($input) use ($value) {
            return $input !== $value;
        };
        $this->assertInstanceOf(NoResult::class, $workflow->filter($filter));
    }

    public function testFilterNot_false()
    {
        $value = 1;
        $workflow = Workflow::new($value);
        $filter = function ($input) use ($value) {
            return $input === $value;
        };
        $this->assertInstanceOf(NoResult::class, $workflow->filterNot($filter));
    }

    public function testFilterNot_true()
    {
        $value = 1;
        $workflow = Workflow::new($value);
        $filter = function ($input) use ($value) {
            return $input !== $value;
        };
        $this->assertInstanceOf(Success::class, $workflow->filterNot($filter));
    }

    public function testMap_success()
    {
        $value = 1;
        $workflow = Workflow::new($value);
        $map = function ($value) {
            return $value + $value;
        };
        $this->assertInstanceOf(Success::class, $workflow->map($map));
    }

    public function testMap_success_hasCorrectValue()
    {
        $value = 1;
        $workflow = Workflow::new($value);
        $map = function ($value) {
            return $value + $value;
        };
        $this->assertSame($map($value), $workflow->map($map)->get());
    }

    public function testMap_success_hasWorkflow()
    {
        $value = 1;
        $workflow = Workflow::new($value);
        $workflowMapped = Workflow::new($value + $value);

        $map = function () use($workflowMapped) {
            return $workflowMapped;
        };
        $this->assertSame($workflowMapped, $workflow->map($map)->get());
    }

    public function testMap_empty()
    {
        $value = 1;
        $workflow = Workflow::new($value);
        $map = function () {
            return null;
        };
        $this->assertInstanceOf(NoResult::class, $workflow->map($map));
    }

    public function testMap_fail_error()
    {
        $value = 1;
        $workflow = Workflow::new($value);
        $map = function () {
            return new class implements Error{};
        };
        $this->assertInstanceOf(Failure::class, $workflow->map($map));
    }

    public function testMap_fail_exception()
    {
        $value = 1;
        $workflow = Workflow::new($value);
        $map = function () {
            return new \Exception();
        };
        $this->assertInstanceOf(Failure::class, $workflow->map($map));
    }

    public function testFlatMap()
    {
        $value = 1;
        $workflow = Workflow::new($value);
        $workflowFlatMapped = Workflow::new($value + $value);
        $flatMap = function () use($workflowFlatMapped) { return $workflowFlatMapped; };
        $this->assertSame($workflowFlatMapped, $workflow->flatMap($flatMap));
    }

    public function testFlatMap_doesNotReturnContainer()
    {
        $this->expectException(\TypeError::class);
        $workflow = Workflow::new(1);
        $flatMap = function ($value) { return $value; };
        $workflow->flatMap($flatMap);
    }

    public function testFlatMap_receivesValue()
    {
        $track = $this->getTracker();
        $workflow = Workflow::new($track);
        $flatMap = function ($track) {
            $track->didUse();
            return Workflow::new($track);
        };

        $this->assertTrue($workflow->flatMap($flatMap)->get()->wasUsed());
    }

    public function testForeach()
    {
        $track = $this->getTracker();
        $workflow = Workflow::new($track);
        $foreach = function ($track) {
            $track->didUse();
        };

        $this->assertTrue($workflow->foreach($foreach)->get()->wasUsed());
    }

    public function testFornothing()
    {
        $track = $this->getTracker();
        $workflow = Workflow::new($track);
        $fornothing = function ($track) {
            $track->didUse();
        };

        $this->assertFalse($workflow->fornothing($fornothing)->get()->wasUsed());
    }

    public function testEquals_true()
    {
        $value = 1;
        $workflow1 = Workflow::new($value);
        $workflow2 = Workflow::new($value);
        $this->assertTrue($workflow1->equals($workflow2));
    }

    public function testEquals_false_unequalValue()
    {
        $value = 1;
        $workflow1 = Workflow::new($value);
        $workflow2 = Workflow::new($value + $value);
        $this->assertFalse($workflow1->equals($workflow2));
    }

    public function testEquals_false_diferentType_sameValue()
    {
        $value = 1;
        $workflow1 = Workflow::new($value);
        $workflow2 = new class($value) extends Workflow {
            use BaseSuccess;

            public function __construct($value)
            {
                $this->value = $value;
            }
        };
        $this->assertFalse($workflow1->equals($workflow2));
    }

    public function testEquals_false_compareToNoResult()
    {
        $value = 1;
        $workflow1 = Workflow::new($value);
        $workflow2 = Workflow::new(null);
        $this->assertFalse($workflow1->equals($workflow2));
    }

    public function testEquals_false_compareToFailure()
    {
        $value = 1;
        $workflow1 = Workflow::new($value);
        $workflow2 = Workflow::new(new class implements Error {});
        $this->assertFalse($workflow1->equals($workflow2));
    }

    public function testIsError()
    {
        $workflow = Workflow::new(1);
        $this->assertFalse($workflow->isError());
    }

    public function testGetError()
    {
        $this->assertFalse(Workflow::new(1)->getError()->isDefined());
    }
}