<?php
declare(strict_types=1);

namespace maarky\Test\Workflow\Task;

use maarky\Option\Option;
use maarky\Workflow\Task\History;
use maarky\Workflow\Workflow;
use PHPUnit\Framework\TestCase;

class HistoryTest extends TestCase
{
    /**
     * @var History
     */
    protected $history;

    public function setUp()
    {
        $this->history = new History();
    }

    public function testAdd()
    {
        $result = $this->history->add(Workflow::new('a'));
        $this->assertInstanceOf(History::class, $result);
    }

    public function testAdd_mustBeWorkflow()
    {
        $this->expectException(\TypeError::class);
        $this->history->add(1);
    }

    public function testBookmark()
    {
        $result = $this->history->bookmark('test', Workflow::new('a'));
        $this->assertInstanceOf(History::class, $result);
    }

    public function testBookmark_notWorkflow()
    {
        $this->expectException(\TypeError::class);
        $this->history->bookmark('test', 1);
    }

    public function testGet_option()
    {
        $this->history->bookmark('test', Workflow::new('a'));
        $result = $this->history->get('test');
        $this->assertInstanceOf(Option::class, $result);
    }

    public function testGet_optionHasValue()
    {
        $workflow = Workflow::new('a');
        $this->history->bookmark('test', $workflow);
        $result = $this->history->get('test')->get();
        $this->assertSame($workflow, $result);
    }

    public function testGet_optionHasNoValue()
    {
        $this->history->bookmark('test', Workflow::new('a'));
        $result = $this->history->get('wrong')->isEmpty();
        $this->assertTrue($result);
    }

    public function testGet_EmptyHistoryHasNoValue()
    {
        $result = $this->history->get('anything')->isEmpty();
        $this->assertTrue($result);
    }

    public function testKey_empty()
    {
        $this->assertNull($this->history->key());
    }

    public function testKey_nonEmpty()
    {
        $workflow = Workflow::new('a');
        $this->history->add($workflow);
        $this->history->add($workflow);
        $this->history->add($workflow);
        $this->history->add($workflow);
        $this->assertEquals(0, $this->history->key());
    }

    public function testNext()
    {
        $workflow = Workflow::new('a');
        $this->history->add($workflow);
        $this->history->add($workflow);
        $this->history->add($workflow);
        $this->history->add($workflow);
        $this->history->next();
        $this->assertEquals(1, $this->history->key());
    }

    public function testRewind()
    {
        $workflow = Workflow::new('a');
        $this->history->add($workflow);
        $this->history->add($workflow);
        $this->history->add($workflow);
        $this->history->add($workflow);
        $this->history->next();
        $this->history->next();
        $this->history->rewind();
        $this->assertEquals(0, $this->history->key());
    }

    public function testValid_true()
    {
        $workflow = Workflow::new('a');
        $this->history->add($workflow);
        $this->history->add($workflow);
        $this->history->add($workflow);
        $this->history->add($workflow);
        $this->assertTrue($this->history->valid());
    }

    public function testValid_false()
    {
        $this->history->add(Workflow::new('a'));
        $this->history->next();
        $this->assertFalse($this->history->valid());
    }

    public function testCurrent()
    {
        $workflow = Workflow::new('a');
        $this->history->add($workflow);
        $this->assertSame($workflow, $this->history->current());
    }

    public function testCurrent_afterNext()
    {
        $workflow1 = Workflow::new('a');
        $workflow2 = Workflow::new('b');
        $this->history->add($workflow1);
        $this->history->add($workflow2);
        $this->history->next();
        $this->assertSame($workflow1, $this->history->current());
    }

    public function testIteratesBackwards()
    {
        $workflow1 = Workflow::new('a');
        $workflow2 = Workflow::new('b');
        $workflow3 = Workflow::new('c');
        $workflow4 = Workflow::new('d');
        $this->history->add($workflow1);
        $this->history->add($workflow2);
        $this->history->add($workflow3);
        $this->history->add($workflow4);
        $expected = [$workflow4, $workflow3, $workflow2, $workflow1];
        $actual = [];
        foreach ($this->history as $result) {
            $actual[] = $result;
        }
        $this->assertSame($expected, $actual);
    }

    public function testLastSuccess_isOption()
    {
        $success = Workflow::new('a');
        $this->history->add(Workflow::new('b'));
        $this->history->add(Workflow::new(null));
        $this->history->add($success);
        $this->history->add(Workflow::new(null));
        $this->history->add(Workflow::new(new \Exception()));
        $lastSuccess = $this->history->getLastSuccess();
        $this->assertInstanceOf(\maarky\Workflow\Option\Option::class, $lastSuccess);
        return [$success, $lastSuccess];
    }

    /**
     * @depends testLastSuccess_isOption
     */
    public function testLastSuccess_isDefined($result)
    {
        $this->assertTrue($result[1]->isDefined());
        return $result;
    }

    /**
     * @depends testLastSuccess_isDefined
     */
    public function testLastSuccess_isSame($result)
    {
        $this->assertSame($result[0], $result[1]->get());
    }

    public function testLastSuccess_isEmpty()
    {
        $this->history->add(Workflow::new(null));
        $this->history->add(Workflow::new(new \Exception()));
        $lastSuccess = $this->history->getLastSuccess()->isEmpty();
        $this->assertTrue($lastSuccess);
    }

    public function testLastSuccess_noHistory_isEmpty()
    {
        $lastSuccess = $this->history->getLastSuccess()->isEmpty();
        $this->assertTrue($lastSuccess);
    }
}
