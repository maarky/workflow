<?php
declare(strict_types=1);

namespace maarky\Test\Workflow\Task\String;

use maarky\Option\Option;
use maarky\Workflow\Task\String\FlatMap;
use maarky\Workflow\Workflow;
use PHPUnit\Framework\TestCase;

class FlatMapTest extends TestCase
{
    public function testStrGetcsv()
    {
        $string = '"a","b","c","d","e","f\""';
        $expected = str_getcsv($string);
        $actual = Workflow::create($string)->flatMap(FlatMap\str_getcsv())->get();
        $this->assertSame($expected, $actual);
    }

    public function testStrGetcsv_delimiter()
    {
        $string = '"a":"b":"c":"d":"e":"f\""';
        $delimeter = ':';
        $expected = str_getcsv($string, $delimeter);
        $actual = Workflow::create($string)->flatMap(FlatMap\str_getcsv($delimeter))->get();
        $this->assertSame($expected, $actual);
    }
    
    public function testStrGetcsv_enclosure()
    {
        $string = ':a:,:b:,:c:,:d:,:e:,:f\::';
        $delimeter = ',';
        $enclosure = ':';
        $expected = str_getcsv($string, $delimeter, $enclosure);
        $actual = Workflow::create($string)->flatMap(FlatMap\str_getcsv($delimeter, $enclosure))->get();
        $this->assertSame($expected, $actual);
    }

    public function testStrGetcsv_escape()
    {
        $string = '"a","b","c","d","e","f-""';
        $delimeter = ',';
        $enclosure = '"';
        $escape = '-';
        $expected = str_getcsv($string, $delimeter, $enclosure, $escape);
        $actual = Workflow::create($string)->flatMap(FlatMap\str_getcsv($delimeter, $enclosure, $escape))->get();
        $this->assertSame($expected, $actual);
    }

    public function testStrGetcsv_map()
    {
        $string = '"a","b","c","d","e","f"';
        $delimeter = ',';
        $enclosure = '"';
        $escape = '\\';
        $class = Workflow::class;
        $actual = Workflow::create($string)->flatMap(FlatMap\str_getcsv($delimeter, $enclosure, $escape, $class));
        $this->assertInstanceOf($class, $actual);
    }

    public function testStr_split()
    {
        $string = 'ab';
        $expected = ['a','b'];
        $actual = Workflow::create($string)->flatMap(FlatMap\str_split())->get();
        $this->assertEquals($expected, $actual);
    }

    public function testStr_split_length()
    {
        $string = 'abcd';
        $length = 2;
        $expected = ['ab','cd'];
        $actual = Workflow::create($string)->flatMap(FlatMap\str_split($length))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testStr_split_class()
    {
        $string = 'abcd';
        $class = Workflow::class;
        $actual = Workflow::create($string)->flatMap(FlatMap\str_split(1, $class));
        $this->assertInstanceOf($class, $actual);
    }
}