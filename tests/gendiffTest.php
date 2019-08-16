<?php

namespace Differ\tests;

use Differ\tests\fixtures;
use function Differ\genDiff\genDiff;
use PHPUnit\Framework\TestCase;

const DIR_FIXTURES = '../tests/fixtures/'
const FILE_JSON_1 = 'before.json';
const FILE_JSON_2 = 'after.json';
const FILE_YAML_1 = 'before.yml';
const FILE_YAML_2 = 'after.yml';
const FILE_R_JSON_1 = 'recursiveBefore.json';
const FILE_R_JSON_2 = 'recursiveAfter.json';

const RES_JSON_PRETTY = __DIR__ . '/fixtures/resJsonPretty';
const RES_YAML_JSON = __DIR__ . '/fixtures/resYamlJson';
const RES_REC_JSON_PRETTY = __DIR__ . '/fixtures/resRecJsonPretty';
const RES_REC_JSON_PLAIN = __DIR__ . '/fixtures/resRecJsonPlain';

class GenDiffTest extends TestCase
{
    /**
     * @dataProvider additionProvider
    */

    public function testGendiff($expected, $nameFile1, $nameFile2, $format = 'pretty')
    {
        $this->assertEquals(file_get_contents($expected), genDiff(DIR_FIXTURES . $nameFile1, DIR_FIXTURES . $nameFile1, $format));
    }

    public function additionProvider()
    {
        return [
            [RES_JSON_PRETTY, FILE_JSON_1, FILE_JSON_2],
            [RES_YAML_JSON, FILE_YAML_1, FILE_YAML_2, 'json'],
            [RES_REC_JSON_PRETTY, FILE_R_JSON_1, FILE_R_JSON_2, 'pretty'],
            [RES_REC_JSON_PLAIN, FILE_R_JSON_1, FILE_R_JSON_2, 'plain'],
        ];
    }
}
