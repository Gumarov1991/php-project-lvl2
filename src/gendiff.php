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
    $unionArr = Collection\union($arrForMerge1, $arrForMerge2);
    $result = array_reduce($unionArr, function ($acc, $value) use ($arrForMerge1, $arrForMerge2, $unionArr) {
        $valueForKey = stringForBool($value);
        $keyUnionArr = array_search($valueForKey, $unionArr);
        if (array_key_exists($keyUnionArr, $arrForMerge1) && array_key_exists($keyUnionArr, $arrForMerge2)) {
            if ($arrForMerge1[$keyUnionArr] === $value && $arrForMerge2[$keyUnionArr] === $value) {
                $acc["  {$keyUnionArr}"] = $value;
            } else {
                $acc["+ {$keyUnionArr}"] = $value;
                $acc["- {$keyUnionArr}"] = $arrForMerge1[$keyUnionArr];
            }
        } elseif (array_key_exists($keyUnionArr, $arrForMerge1)) {
            $acc["- {$keyUnionArr}"] = $value;
        } else {
            $acc["+ {$keyUnionArr}"] = $value;
        }
        return $acc;
    }, []);
    return json_encode($result);
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
