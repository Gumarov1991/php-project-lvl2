<?php

namespace Differ\tests;

use Differ\tests\fixtures;
use function Differ\genDiff\genDiff;
use PHPUnit\Framework\TestCase;

const FILE_JSON_1 = '../tests/fixtures/before.json';
const FILE_JSON_2 = '../tests/fixtures/after.json';
const FILE_YAML_1 = '../tests/fixtures/before.yml';
const FILE_YAML_2 = '../tests/fixtures/after.yml';
const FILE_R_JSON_1 = '../tests/fixtures/recursiveBefore.json';
const FILE_R_JSON_2 = '../tests/fixtures/recursiveAfter.json';
const FILE_NONEXISTENT = '../tests/fixtures/FILE_NONEXISTENT';

const RES_JSON_PRETTY = __DIR__ . '/fixtures/resJsonPretty';
const RES_YAML_JSON = __DIR__ . '/fixtures/resYamlJson';
const RES_REC_JSON_PRETTY = __DIR__ . '/fixtures/resRecJsonPretty';
const RES_REC_JSON_PLAIN = __DIR__ . '/fixtures/resRecJsonPlain';
const RES_WITH_ERROR = "Error reading file '" . FILE_NONEXISTENT . "'";

class GenDiffTest extends TestCase
{
    /**
     * @dataProvider additionProvider
    */

    public function testGendiff($expected, $pathToFile1, $pathToFile2, $format = 'pretty')
    {
        $this->assertEquals($expected, genDiff($pathToFile1, $pathToFile2, $format));
    }

    public function additionProvider()
    {
        return [
            [file_get_contents(RES_JSON_PRETTY), FILE_JSON_1, FILE_JSON_2],
            [file_get_contents(RES_YAML_JSON), FILE_YAML_1, FILE_YAML_2, 'json'],
            [file_get_contents(RES_REC_JSON_PRETTY), FILE_R_JSON_1, FILE_R_JSON_2, 'pretty'],
            [file_get_contents(RES_REC_JSON_PLAIN), FILE_R_JSON_1, FILE_R_JSON_2, 'plain'],
            [RES_WITH_ERROR, FILE_NONEXISTENT, FILE_R_JSON_2]
        ];
    }
}
