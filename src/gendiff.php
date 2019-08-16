<?php

namespace Differ\genDiff;

use function Differ\parsers\genData;
use Docopt;
use Funct\Collection;

const DOCOPT = <<<'DOCOPT'
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

function run()
{
    $docopt = getArgs(DOCOPT);
    $pathToFile1 = $docopt['<firstFile>'];
    $pathToFile2 = $docopt['<secondFile>'];
    $format = $docopt['--format'];
    print_r(genDiff($pathToFile1, $pathToFile2, $format));
}

function getArgs($content)
{
    return Docopt::handle($content, ['version' => '1.0.0']);
}

function genDiff($pathToFile1, $pathToFile2, $format = 'pretty')
{
    try {
        $arr1 = genData($pathToFile1);
        $arr2 = genData($pathToFile2);
        $ast = buildAst($arr1, $arr2);
        $genRender = "Differ\\Formatters\\{$format}\\genRender";
        return $genRender($ast);
    } catch (\Exception $e) {
        print_r($e->getMessage());
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
