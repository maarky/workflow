<?php


namespace maarky\Test\Workflow;

use maarky\Workflow\Component\BaseSuccess;
use maarky\Workflow\Error;
use maarky\Workflow\Failure;
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
        $workflow = Workflow::create($value);
        $actual = $workflow->get();
        $this->assertSame($value, $actual);
    }

    public function testGetOrElse()
    {
        $value = 1;
        $workflow = Workflow::create($value);
        $this->assertSame($value, $workflow->getOrElse($value + $value));
    }

    public function testGetOrCall()
    {
        $value = 1;
        $workflow = Workflow::create($value);
        $this->assertSame($value, $workflow->getOrCall('strtolower'));
    }

    public function testOrElse()
    {
        $workflow = Workflow::create(1);
        $this->assertSame($workflow, $workflow->orElse(Workflow::create(2)));
    }

    public function testOrCall()
    {
        $workflow = Workflow::create(1);
        $this->assertSame($workflow, $workflow->orCall('strtolower'));
    }

    public function testIsDefined()
    {
        $this->assertTrue(Workflow::create(1)->isDefined());
    }

    public function testIsEmpty()
    {
        $this->assertFalse(Workflow::create(1)->isEmpty());
    }

    public function testFilter_true()
    {
        $value = 1;
        $workflow = Workflow::create($value);
        $filter = function ($input) use ($value) {
            return $input === $value;
        };
        $this->assertInstanceOf(Success::class, $workflow->filter($filter));
    }

    public function testFilter_false()
    {
        $value = 1;
        $workflow = Workflow::create($value);
        $filter = function ($input) use ($value) {
            return $input !== $value;
        };
        $this->assertTrue($workflow->filter($filter)->isEmpty());
    }

    public function testFilterNot_false()
    {
        $value = 1;
        $workflow = Workflow::create($value);
        $filter = function ($input) use ($value) {
            return $input === $value;
        };
        $this->assertTrue($workflow->filterNot($filter)->isEmpty());
    }

    public function testFilterNot_true()
    {
        $value = 1;
        $workflow = Workflow::create($value);
        $filter = function ($input) use ($value) {
            return $input !== $value;
        };
        $this->assertTrue($workflow->filterNot($filter)->isDefined());
    }

    public function testMap_success()
    {
        $value = 1;
        $workflow = Workflow::create($value);
        $map = function ($value) {
            return $value + $value;
        };
        $this->assertInstanceOf(Success::class, $workflow->map($map));
    }

    public function testMap_success_hasCorrectValue()
    {
        $value = 1;
        $workflow = Workflow::create($value);
        $map = function ($value) {
            return $value + $value;
        };
        $this->assertSame($map($value), $workflow->map($map)->get());
    }

    public function testMap_success_hasWorkflow()
    {
        $value = 1;
        $workflow = Workflow::create($value);
        $workflowMapped = Workflow::create($value + $value);

        $map = function () use($workflowMapped) {
            return $workflowMapped;
        };
        $this->assertSame($workflowMapped, $workflow->map($map)->get());
    }

    public function testMap_empty()
    {
        $value = 1;
        $workflow = Workflow::create($value);
        $map = function () {
            return null;
        };
        $this->assertTrue($workflow->map($map)->isEmpty());
    }

    public function testMap_fail_error()
    {
        $value = 1;
        $workflow = Workflow::create($value);
        $map = function () {
            return new class implements Error{};
        };
        $this->assertInstanceOf(Failure::class, $workflow->map($map));
    }

    public function testMap_fail_exception()
    {
        $value = 1;
        $workflow = Workflow::create($value);
        $map = function () {
            return new \Exception();
        };
        $this->assertInstanceOf(Failure::class, $workflow->map($map));
    }

    public function testFlatMap()
    {
        $value = 1;
        $workflow = Workflow::create($value);
        $workflowFlatMapped = Workflow::create($value + $value);
        $flatMap = function () use($workflowFlatMapped) { return $workflowFlatMapped; };
        $this->assertSame($workflowFlatMapped, $workflow->flatMap($flatMap));
    }

    public function testFlatMap_doesNotReturnContainer()
    {
        $this->expectException(\TypeError::class);
        $workflow = Workflow::create(1);
        $flatMap = function ($value) { return $value; };
        $workflow->flatMap($flatMap);
    }

    public function testFlatMap_receivesValue()
    {
        $track = $this->getTracker();
        $workflow = Workflow::create($track);
        $flatMap = function ($track) {
            $track->didUse();
            return Workflow::create($track);
        };
        $workflow->flatMap($flatMap);

        $this->assertTrue($track->wasUsed());
    }

    public function testForeach()
    {
        $track = $this->getTracker();
        $workflow = Workflow::create($track);
        $foreach = function ($track) {
            $track->didUse();
        };
        $workflow->foreach($foreach);
        $this->assertTrue($track->wasUsed());
    }

    public function testFornothing()
    {
        $track = $this->getTracker();
        $workflow = Workflow::create($track);
        $fornothing = function ($track) {
            $track->didUse();
        };
        $workflow->fornothing($fornothing);
        $this->assertFalse($track->wasUsed());
    }

    public function testEquals_true()
    {
        $value = 1;
        $workflow1 = Workflow::create($value);
        $workflow2 = Workflow::create($value);
        $this->assertTrue($workflow1->equals($workflow2));
    }

    public function testEquals_false_unequalValue()
    {
        $value = 1;
        $workflow1 = Workflow::create($value);
        $workflow2 = Workflow::create($value + $value);
        $this->assertFalse($workflow1->equals($workflow2));
    }

    public function testEquals_false_diferentType_sameValue()
    {
        $value = 1;
        $workflow1 = Workflow::create($value);
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
        $workflow1 = Workflow::create($value);
        $workflow2 = Workflow::create(null);
        $this->assertFalse($workflow1->equals($workflow2));
    }

    public function testEquals_false_compareToFailure()
    {
        $value = 1;
        $workflow1 = Workflow::create($value);
        $workflow2 = Workflow::create(new class implements Error {});
        $this->assertFalse($workflow1->equals($workflow2));
    }

    public function testIsError()
    {
        $workflow = Workflow::create(1);
        $this->assertFalse($workflow->isError());
    }

    public function testGetError()
    {
        $this->assertFalse(Workflow::create(1)->getError()->isDefined());
    }

    public function testGetParent_none()
    {
        $this->assertTrue(Workflow::create(1)->getParent()->isEmpty());
    }
}