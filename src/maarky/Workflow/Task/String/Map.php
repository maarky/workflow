<?php
declare(strict_types=1);

namespace maarky\Workflow\Task\String\Map;

use maarky\Workflow\Task\Utility;

function addcslashes(string $charlist)
{
    $callback = function ($string) use($charlist) {
        return \addcslashes($string, $charlist);
    };
    return Utility::doStringCallback($callback);
}

function explode(string $delimiter, int $limit = PHP_INT_MAX)
{
    $callback = function ($string) use($delimiter, $limit) {
        return \explode($delimiter, $string, $limit);
    };
    return Utility::doStringCallback($callback);
}

function html_entity_decode($flags = null, string $encoding = null)
{
    $flags = Utility::getFlags(ENT_COMPAT | ENT_HTML401, $flags);
    $encoding = Utility::getEncoding(ini_get('default_charset'), $encoding);
    $callback = function ($string) use($flags, $encoding) {
        return \html_entity_decode($string, $flags, $encoding);
    };
    return Utility::doStringCallback($callback);
}

function htmlentities($flags = null, string $encoding = null, bool $doubleEncode = true)
{
    $flags = Utility::getFlags(ENT_COMPAT | ENT_HTML401, $flags);
    $encoding = Utility::getEncoding(ini_get('default_charset'), $encoding);
    $callback = function ($string) use($flags, $encoding, $doubleEncode) {
        return \htmlentities($string, $flags, $encoding, $doubleEncode);
    };
    return Utility::doStringCallback($callback);
}

function htmlspecialchars_decode($flags = null)
{
    $flags = Utility::getFlags(ENT_COMPAT | ENT_HTML401, $flags);
    $callback = function ($string) use($flags) {
        return \htmlspecialchars_decode($string, $flags);
    };
    return Utility::doStringCallback($callback);
}

function htmlspecialchars($flags = null, string $encoding = null, bool $doubleEncode = true)
{
    $flags = Utility::getFlags(ENT_COMPAT | ENT_HTML401, $flags);
    $encoding = Utility::getEncoding(ini_get('default_charset'), $encoding);
    $callback = function ($string) use($flags, $encoding, $doubleEncode) {
        return \htmlspecialchars($string, $flags, $encoding, $doubleEncode);
    };
    return Utility::doStringCallback($callback);
}

function ltrim(string $characterMask = null)
{
    $callback = function ($string) use($characterMask) {
        if(null === $characterMask) {
            return \ltrim($string);
        }
        return \ltrim($string, $characterMask);
    };
    return Utility::doStringCallback($callback);
}

function md5(bool $rawOutput = false)
{
    $callback = function ($string) use($rawOutput) {
        return \md5($string, $rawOutput);
    };
    return Utility::doStringCallback($callback);
}

function nl2br(bool $xhtml = true)
{
    $callback = function ($string) use($xhtml) {
        return \nl2br($string, $xhtml);
    };
    return Utility::doStringCallback($callback);
}

function rtrim(string $characterMask = null)
{
    $callback = function ($string) use($characterMask) {
        if(null === $characterMask) {
            return \rtrim($string);
        }
        return \rtrim($string, $characterMask);
    };
    return Utility::doStringCallback($callback);
}

function sha1(bool $rawOutput = false)
{
    $callback = function ($string) use($rawOutput) {
        return \sha1($string, $rawOutput);
    };
    return Utility::doStringCallback($callback);
}

function str_ireplace($search, $replace)
{
    $callback = function ($string) use($search, $replace) {
        return \str_ireplace($search, $replace, $string);
    };
    return Utility::doStringCallback($callback);
}

function str_pad(int $padLength, string $padString = " ", int $padType = STR_PAD_RIGHT)
{
    $callback = function ($string) use($padLength, $padString, $padType) {
        return \str_pad($string, $padLength, $padString, $padType);
    };
    return Utility::doStringCallback($callback);
}

function str_repeat(int $multiplier)
{
    $callback = function ($string) use($multiplier) {
        return \str_repeat($string, $multiplier);
    };
    return Utility::doStringCallback($callback);
}

function str_replace($search, $replace)
{
    $callback = function ($string) use($search, $replace) {
        return \str_replace($search, $replace, $string);
    };
    return Utility::doStringCallback($callback);
}