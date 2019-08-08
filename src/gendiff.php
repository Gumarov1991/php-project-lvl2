<?php

namespace Differ;

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
    $firstFile = $docopt['<firstFile>'];
    $secondFile = $docopt['<secondFile>'];
    printing(genDiff($firstFile, $secondFile));
}

function genDiff($pathToFile1, $pathToFile2)
{
    $readyPathToFile1 = $pathToFile1[0] === '/' ? $pathToFile1 : __DIR__ . "/{$pathToFile1}";
    $readyPathToFile2 = $pathToFile2[0] === '/' ? $pathToFile2 : __DIR__ . "/{$pathToFile2}";
    $file1Data = json_decode(file_get_contents($readyPathToFile1), true);
    $file2Data = json_decode(file_get_contents($readyPathToFile2), true);
    $filesUnion = Collection\union($file1Data, $file2Data);
    $result = array_reduce($filesUnion, function ($acc, $value) use ($file1Data, $file2Data, $filesUnion) {
        $valueForKey = stringForBool($value);
        $keyFilesUnion = array_search($valueForKey, $filesUnion);
        if (array_key_exists($keyFilesUnion, $file1Data) && array_key_exists($keyFilesUnion, $file2Data)) {
            if ($file1Data[$keyFilesUnion] === $value && $file2Data[$keyFilesUnion] === $value) {
                $acc["  {$keyFilesUnion}"] = $value;
            } else {
                $acc["+ {$keyFilesUnion}"] = $value;
                $acc["- {$keyFilesUnion}"] = $file1Data[$keyFilesUnion];
            }
        } elseif (array_key_exists($keyFilesUnion, $file1Data)) {
            $acc["- {$keyFilesUnion}"] = $value;
        } else {
            $acc["+ {$keyFilesUnion}"] = $value;
        }
        return $acc;
    }, []);
    print_r(json_encode($result, JSON_PRETTY_PRINT));
    return json_encode($result, JSON_PRETTY_PRINT);
}

function printing($print)
{
    $result = json_decode($print, true);
    print_r("{\n");
    foreach ($result as $key => $value) {
        $valueForPrint = stringForBool($value);
        print_r('   ' . $key . ': ' . $valueForPrint . PHP_EOL);
    }
    print_r("}\n");
}

function stringForBool($value)
{
    if (gettype($value) === 'boolean') {
        return $value ? 'true' : 'false';
    }
    return $value;
}
