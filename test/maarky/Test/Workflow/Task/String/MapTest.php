<?php
declare(strict_types=1);

namespace maarky\Test\Workflow\Task\String;

use maarky\Workflow\Task\String\Map;
use maarky\Workflow\Workflow;
use PHPUnit\Framework\TestCase;

class MapTest extends TestCase
{
    public function testAddcslashes()
    {
        $string = "zoo['.']";
        $charlist = 'A..z';
        $expected = \addcslashes($string, $charlist);
        $actual = Workflow::create($string)->map(Map\addcslashes($charlist))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testHtmlEntityDecode()
    {
        $string = "I'll &quot;walk&quot; the &lt;b&gt;dog&lt;/b&gt; now";
        $expected = \html_entity_decode($string);
        $actual = Workflow::create($string)->map(Map\html_entity_decode())->get();
        $this->assertEquals($expected, $actual);
    }

    public function testHtmlEntityDecode_flag()
    {
        $string = "I'll &quot;walk&quot; the &lt;b&gt;dog&lt;/b&gt; now";
        $flag = ENT_NOQUOTES;
        $expected = \html_entity_decode($string, $flag);
        $actual = Workflow::create($string)->map(Map\html_entity_decode($flag))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testHtmlEntityDecode_flag_encoding()
    {
        $string = "I'll &quot;walk&quot; the &lt;b&gt;dog&lt;/b&gt; now";
        $flag = ENT_NOQUOTES;
        $encoding = 'ISO-8859-1';
        $expected = \html_entity_decode($string, $flag, $encoding);
        $actual = Workflow::create($string)->map(Map\html_entity_decode($flag, $encoding))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testHtmlentities()
    {
        $string = '<b>';
        $expected = htmlentities($string);
        $actual = Workflow::create($string)->map(Map\htmlentities())->get();
        $this->assertEquals($expected, $actual);
    }

    public function testHtmlentities_flag()
    {
        $string = '"';
        $flag = ENT_NOQUOTES;
        $expected = htmlentities($string, $flag);
        $actual = Workflow::create($string)->map(Map\htmlentities($flag))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testHtmlentities_doubleEncode()
    {
        $string = '&quot;';
        $doubleEncode = false;
        $expected = htmlentities($string, ENT_COMPAT | ENT_HTML401, ini_get('default_charset'), $doubleEncode);
        $actual = Workflow::create($string)->map(Map\htmlentities(null, null, $doubleEncode))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testHtmlspecialchars_decode()
    {
        $string = '<p>this -&gt; &quot;</p>\n';
        $expected = htmlspecialchars_decode($string);
        $actual = Workflow::create($string)->map(Map\htmlspecialchars_decode())->get();
        $this->assertEquals($expected, $actual);
    }

    public function testHtmlspecialchars_decode_flags()
    {
        $string = '<p>this -&gt; &quot;</p>\n';
        $flag = ENT_NOQUOTES;
        $expected = htmlspecialchars_decode($string, $flag);
        $actual = Workflow::create($string)->map(Map\htmlspecialchars_decode($flag))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testHtmlspecialchars()
    {
        $string = "<a href='test'>Test</a>";
        $expected = htmlspecialchars($string);
        $actual = Workflow::create($string)->map(Map\htmlspecialchars())->get();
        $this->assertEquals($expected, $actual);
    }

    public function testHtmlspecialchars_flag()
    {
        $string = "<a href='test'>Test</a>";
        $flag = ENT_NOQUOTES;
        $expected = htmlspecialchars($string, $flag);
        $actual = Workflow::create($string)->map(Map\htmlspecialchars($flag))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testHtmlspecialchars_doubleEncode()
    {
        $string = "<a href='test'>Test</a>";
        $doubleEncode = false;
        $expected = htmlspecialchars($string, ENT_COMPAT | ENT_HTML401, ini_get('default_charset'), $doubleEncode);
        $actual = Workflow::create($string)->map(Map\htmlspecialchars(null, null, $doubleEncode))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testLtrim()
    {
        $string = ' g';
        $expected = ltrim($string);
        $actual = Workflow::create($string)->map(Map\ltrim())->get();
        $this->assertEquals($expected, $actual);
    }

    public function testLtrim_mask()
    {
        $string = '-g';
        $mask = '-';
        $expected = ltrim($string, $mask);
        $actual = Workflow::create($string)->map(Map\ltrim($mask))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testMd5()
    {
        $string = 'a';
        $expected = md5($string);
        $actual = Workflow::create($string)->map(Map\md5())->get();
        $this->assertEquals($expected, $actual);
    }

    public function testMd5_raw()
    {
        $string = 'a';
        $raw = true;
        $expected = md5($string, $raw);
        $actual = Workflow::create($string)->map(Map\md5($raw))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testMd5_basicUsage()
    {
        $string = 'a';
        $expected = Workflow::create($string)->map(Map\md5())->get();
        $actual = Workflow::create($string)->map('md5')->get();
        $this->assertEquals($expected, $actual);
    }

    public function testNl2br()
    {
        $string = "a\nb";
        $expected = nl2br($string);
        $actual = Workflow::create($string)->map(Map\nl2br())->get();
        $this->assertEquals($expected, $actual);
    }

    public function testNl2br_notXhtml()
    {
        $string = "a\nb";
        $xhtml = false;
        $expected = nl2br($string, $xhtml);
        $actual = Workflow::create($string)->map(Map\nl2br($xhtml))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testRtrim()
    {
        $string = ' g';
        $expected = rtrim($string);
        $actual = Workflow::create($string)->map(Map\rtrim())->get();
        $this->assertEquals($expected, $actual);
    }

    public function testRtrim_mask()
    {
        $string = '-g';
        $mask = '-';
        $expected = rtrim($string, $mask);
        $actual = Workflow::create($string)->map(Map\rtrim($mask))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testSha1()
    {
        $string = 'a';
        $expected = sha1($string);
        $actual = Workflow::create($string)->map(Map\sha1())->get();
        $this->assertEquals($expected, $actual);
    }

    public function testSha1_raw()
    {
        $string = 'a';
        $raw = true;
        $expected = sha1($string, $raw);
        $actual = Workflow::create($string)->map(Map\sha1($raw))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testStr_ireplace()
    {
        $string = 'a';
        $search = 'A';
        $replace = 'b';
        $expected = 'b';
        $actual = Workflow::create($string)->map(Map\str_ireplace($search, $replace))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testStr_ireplace_none()
    {
        $string = 'a';
        $search = 'B';
        $replace = 'c';
        $expected = 'a';
        $actual = Workflow::create($string)->map(Map\str_ireplace($search, $replace))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testStr_ireplace_many()
    {
        $string = 'ab';
        $search = ['A', 'B'];
        $replace = ['c', 'd'];
        $expected = 'cd';
        $actual = Workflow::create($string)->map(Map\str_ireplace($search, $replace))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testStr_ireplace_error()
    {
        $string = 'ab';
        $search = new \stdClass();
        $replace = ['c', 'd'];
        $actual = Workflow::create($string)->map(Map\str_ireplace($search, $replace));
        $this->assertTrue($actual->isError());
    }

    public function testStr_pad()
    {
        $string = 'a';
        $length = 2;
        $expected = 'a ';
        $actual = Workflow::create($string)->map(Map\str_pad($length))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testStr_pad_string()
    {
        $string = 'a';
        $string2 = 'b';
        $length = 2;
        $expected = 'ab';
        $actual = Workflow::create($string)->map(Map\str_pad($length, $string2))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testStr_pad_string_left()
    {
        $string = 'a';
        $string2 = 'b';
        $type = STR_PAD_LEFT;
        $length = 2;
        $expected = 'ba';
        $actual = Workflow::create($string)->map(Map\str_pad($length, $string2, $type))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testStr_repeat()
    {
        $string = 'a';
        $multiplier = 2;
        $expected = 'aa';
        $actual = Workflow::create($string)->map(Map\str_repeat($multiplier))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testStr_replace()
    {
        $string = 'a';
        $search = 'a';
        $replace = 'b';
        $expected = 'b';
        $actual = Workflow::create($string)->map(Map\str_replace($search, $replace))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testStr_replace_none()
    {
        $string = 'a';
        $search = 'b';
        $replace = 'c';
        $expected = 'a';
        $actual = Workflow::create($string)->map(Map\str_replace($search, $replace))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testStr_replace_many()
    {
        $string = 'ab';
        $search = ['a', 'b'];
        $replace = ['c', 'd'];
        $expected = 'cd';
        $actual = Workflow::create($string)->map(Map\str_replace($search, $replace))->get();
        $this->assertEquals($expected, $actual);
    }

    public function testStr_replace_error()
    {
        $string = 'ab';
        $search = new \stdClass();
        $replace = ['c', 'd'];
        $actual = Workflow::create($string)->map(Map\str_replace($search, $replace));
        $this->assertTrue($actual->isError());
    }

    public function testStr_replace_case()
    {
        $string = 'a';
        $search = 'A';
        $replace = 'b';
        $expected = 'a';
        $actual = Workflow::create($string)->map(Map\str_replace($search, $replace))->get();
        $this->assertEquals($expected, $actual);
    }
}