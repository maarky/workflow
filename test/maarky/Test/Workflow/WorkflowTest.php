<?php


namespace maarky\Test\Workflow;

use maarky\Workflow\Error;
use maarky\Workflow\Failure;
use maarky\Workflow\NoResult;
use maarky\Workflow\Success;
use maarky\Workflow\Workflow;
use PHPUnit\Framework\TestCase;


class WorkflowTest extends TestCase
{
    public function testNew_success()
    {
        $this->assertInstanceOf(Success::class, Workflow::new(1));
    }

    public function testNew_failure_throwable()
    {
        $this->assertInstanceOf(Failure::class, Workflow::new(new \Exception()));
    }

    public function testNew_failure_error()
    {
        $this->assertInstanceOf(Failure::class, Workflow::new(new class implements Error{}));
    }

    public function testNew_noResult()
    {
        $this->assertInstanceOf(NoResult::class, Workflow::new(null));
    }

    public function testIsValid_true()
    {
        $this->assertTrue(Workflow::isValid(1));
    }

    public function testIsValid_false_empty()
    {
        $this->assertFalse(Workflow::isValid(null));
    }

    public function testIsValid_false_error()
    {
        $this->assertFalse(Workflow::isValid(new class implements Error{}));
    }

    public function testIsValid_false_exception()
    {
        $this->assertFalse(Workflow::isValid(new \Exception()));
    }
}