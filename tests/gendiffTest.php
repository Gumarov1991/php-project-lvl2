<?php

namespace Differ\tests;

use Differ\tests\fixtures;
use function Differ\genDiff\genDiff;
use PHPUnit\Framework\TestCase;

class GenDiff extends TestCase
{
    public function testGendiff()
    {
        $this->assertEquals(fixtures\RESULT_JSON_PRETTY, genDiff(fixtures\FILE_JSON_1, fixtures\FILE_JSON_2));
        $this->assertEquals(fixtures\RESULT_YAML_JSON, genDiff(fixtures\FILE_YAML_1, fixtures\FILE_YAML_2, 'json'));
        $this->assertEquals(fixtures\RESULT_R_JSON_PRETTY, genDiff(fixtures\FILE_R_JSON_1, fixtures\FILE_R_JSON_2, 'pretty'));
        $this->assertEquals(fixtures\RESULT_R_JSON_PLAIN, genDiff(fixtures\FILE_R_JSON_1, fixtures\FILE_R_JSON_2, 'plain'));
    }
}
