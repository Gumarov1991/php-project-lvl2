<?php

namespace Differ\tests;

use Differ\tests\fixtures\DataTest;
use function Differ\genDiff\genDiff;
use PHPUnit\Framework\TestCase;

class GenDiff extends TestCase
{
    public function testGendiff()
    {
        $this->assertEquals(DataTest::RESULT_JSON, genDiff(DataTest::FILE_JSON_1, DataTest::FILE_JSON_2));
        $this->assertEquals(DataTest::RESULT_YAML, genDiff(DataTest::FILE_YAML_1, DataTest::FILE_YAML_2));
    }
}
