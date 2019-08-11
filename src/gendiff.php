<?php

namespace Differ\genDiff;

use Differ\parsers\Parser;
use Funct\Collection;
use Docopt;

function run()
{
    $doc = <<<'DOCOPT'
    Generate diff

    Usage:
        gendiff (-h|--help)
        gendiff (-v|--version)
        gendiff [--format <fmt>] <firstFile> <secondFile>

    Options:
        -h --help                     Show this screen
        -v --version                  Show version
        --format <fmt>                Report format [default: pretty]
DOCOPT;
    $docopt = Docopt::handle($doc, ['version' => '1.0.0']);
    $file1 = $docopt['<firstFile>'];
    $file2 = $docopt['<secondFile>'];
    printing(genDiff($file1, $file2));
}

function genDiff($file1, $file2)
{
    $parser1 = new Parser($file1);
    $parser2 = new Parser($file2);
    $arrForMerge1 = $parser1->genArrForMerge();
    $arrForMerge2 = $parser2->genArrForMerge();
    $mergeArr = genMergeArr($arrForMerge1, $arrForMerge2);
    return json_encode(prepareDiff($arrForMerge1, $arrForMerge2, $mergeArr));
}

function genMergeArr($arr1, $arr2)
{
    foreach ($arr2 as $key => $val) {
        if (is_array($val)) {
            if (isset($arr1[$key]) && is_array($arr1[$key])) {
                $arr1[$key] = genMergeArr($arr1[$key], $val);
            } else {
                $arr1[$key] = $val;
            }
        } else {
            $arr1[$key] = $val;
        }
    }
    return $arr1;
}

function prepareDiff($arr1, $arr2, $mergeArr)
{
    $arrResult = [];
    foreach ($mergeArr as $key => $val) {
        if (is_array($val)) {
            if (isset($arr1[$key]) && isset($arr2[$key])) {
                $arrResult["  {$key}"] = prepareDiff($arr1[$key], $arr2[$key], $mergeArr[$key]);
            } elseif (isset($arr2[$key])) {
                $arrResult["+ {$key}"] = prepareDiff($arr2[$key], $arr2[$key], $mergeArr[$key]);
            } else {
                $arrResult["- {$key}"] = prepareDiff($arr1[$key], $arr1[$key], $mergeArr[$key]);
            }
        } elseif (isset($arr1[$key]) && isset($arr2[$key])) {
            if ($arr1[$key] === $val) {
                $arrResult["  {$key}"] = $val;
            } else {
                $arrResult["+ {$key}"] = $val;
                $arrResult["- {$key}"] = $arr1[$key];
            }
        } elseif (isset($arr2[$key])) {
            $arrResult["+ {$key}"] = $val;
        } else {
            $arrResult["- {$key}"] = $val;
        }
    }
    return $arrResult;
}


function printing($print, $key = "", $countSpacesForIndent = 0)
{
    $decoded = isJson($print) ? json_decode($print, true) : $print;
    $indent = genIndentForPrinting($countSpacesForIndent);
    if (is_array($decoded)) {
        print_r("$indent$key: {\n");
        foreach ($decoded as $key => $value) {
            printing($value, $key, $countSpacesForIndent + 4);
        }
        print_r("$indent  }\n");
    } else {
        $string = genStringFromBool($decoded);
        print_r("$indent$key: $string\n");
    }
}

function genIndentForPrinting($count)
{
    $result = '';
    for ($i = 0; $i < $count; $i++) {
        $result .= ' ';
    }
    return $result;
}

function genStringFromBool($value)
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    return $value;
}

function isJson($string)
{
    return is_string($string) && is_array(json_decode($string, true)) ? true : false;
}
