<?php


namespace maarky\Test\Workflow\Type;

use maarky\Workflow\Error;
use maarky\Workflow\Type\Callback\Workflow;
use PHPUnit\Framework\TestCase;


class CallbackTest extends TestCase
{
    public function testIsValid_Arr()
    {
        $value = [];
        $this->assertFalse(Workflow::isValid($value));
    }

    public function testIsValid_Bool()
    {
        $value = true;
        $this->assertFalse(Workflow::isValid($value));
    }

    public function testIsValid_Callback()
    {
        $value = function (){};
        $this->assertTrue(Workflow::isValid($value));
    }

    public function testIsValid_Float()
    {
        $value = 1.1;
        $this->assertFalse(Workflow::isValid($value));
    }

    public function testIsValid_Int()
    {
        $value = 1;
        $this->assertFalse(Workflow::isValid($value));
    }

    public function testIsValid_Null()
    {
        $value = null;
        $this->assertFalse(Workflow::isValid($value));
    }

    public function testIsValid_Object()
    {
        $value = $this;
        $this->assertFalse(Workflow::isValid($value));
    }

    public function testIsValid_Resource()
    {
        $value = fopen(__FILE__, 'r');
        $this->assertFalse(Workflow::isValid($value));
    }

    public function testIsValid_String()
    {
        $value = '';
        $this->assertFalse(Workflow::isValid($value));
    }

    public function testIsValid_Error()
    {
        $value = new class implements Error {};
        $this->assertFalse(Workflow::isValid($value));
    }

    public function testIsValid_Exception()
    {
        $value = new \Exception();
        $this->assertFalse(Workflow::isValid($value));
    }
}