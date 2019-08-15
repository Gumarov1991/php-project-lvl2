<?php

namespace Differ\genDiff;

use function Differ\parsers\genData;
use Docopt;
use Funct\Collection;

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
    $format = $docopt['--format'];
    $pathToFile1 = $docopt['<firstFile>'];
    $pathToFile2 = $docopt['<secondFile>'];
    print_r(genDiff($pathToFile1, $pathToFile2, $format));
}

function genDiff($pathToFile1, $pathToFile2, $format = 'pretty')
{
    $arr1 = genData($pathToFile1);
    $arr2 = genData($pathToFile2);
    if ($arr1 && $arr2) {
        $ast = buildAst($arr1, $arr2);
        $printing = "Differ\\Formatters\\{$format}\\printing";
        return $printing($ast);
    } elseif (!$arr1) {
        return "Error reading file '{$pathToFile1}'";
    } else {
        return "Error reading file '{$pathToFile2}'";
    }
}

function buildAst($arr1, $arr2)
{
    $unionKeys = Collection\union(array_keys($arr1), array_keys($arr2));
    $result = array_reduce($unionKeys, function ($acc, $value) use ($arr1, $arr2) {
        if (isset($arr1[$value]) && !isset($arr2[$value])) {
            $status = 'deleted';
            $acc[] = buildNode($status, $value, $arr1[$value], '');
        } elseif (!isset($arr1[$value])) {
            $status = 'added';
            $acc[] = buildNode($status, $value, $arr2[$value], '');
        } elseif (is_array($arr1[$value]) && is_array($arr2[$value])) {
            $status = 'nested';
            $children = buildAST($arr1[$value], $arr2[$value]);
            $acc[] = buildNode($status, $value, '', '', $children);
        } elseif ($arr1[$value] === $arr2[$value]) {
            $status = 'not changed';
            $acc[] = buildNode($status, $value, $arr1[$value], $arr2[$value]);
        } else {
            $status = 'changed';
            $acc[] = buildNode($status, $value, $arr1[$value], $arr2[$value]);
        }
        return $acc;
    });
    return $result;
}

function buildNode($status, $name, $oldValue, $newValue, $children = [])
{
    return [
        'status' => $status,
        'name' => $name,
        'oldValue' => $oldValue,
        'newValue' => $newValue,
        'children' => $children
    ];
}
