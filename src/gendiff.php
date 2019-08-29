<?php

namespace Differ\genDiff;

use Docopt;
use Funct\Collection;
use function Differ\parsers\parse;

function genDiff($pathToFile1, $pathToFile2, $format = 'pretty')
{
    $firstFileExtension = pathinfo($pathToFile1, PATHINFO_EXTENSION);
    $secondFileExtension = pathinfo($pathToFile2, PATHINFO_EXTENSION);

    $firstFileData = file_get_contents(genAbsolutPath($pathToFile1));
    $secondFileData = file_get_contents(genAbsolutPath($pathToFile2));

    $arr1 = parse($firstFileData, $firstFileExtension);
    $arr2 = parse($secondFileData, $secondFileExtension);
    
    $ast = buildAst($arr1, $arr2);
    $genRender = "Differ\\Formatters\\{$format}\\genRender";
    return $genRender($ast);
}

function genAbsolutPath($pathToFile)
{
    $absolutPath = $pathToFile[0] === '/' ? $pathToFile : __DIR__ . "/{$pathToFile}";
    if (file_exists($absolutPath)) {
        return $absolutPath;
    }
    throw new \Exception("The '{$pathToFile}' doesn't exists");
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
