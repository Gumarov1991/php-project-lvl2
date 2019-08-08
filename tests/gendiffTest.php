<?php

namespace Tests;

use function Differ\genDiff;
use PHPUnit\Framework\TestCase;

class GenDiff extends TestCase
{
    public function testGendiff()
    {
        $result = {
            "  host": "hexlet.io",
            "+ timeout": 20,
            "- timeout": 50,
            "- proxy": "123.234.53.22",
            "+ verbose": true
        };
        $this->assertEquals($result, genDiff('../tests/fixtures/before.json', '../tests/fixtures/after.json'));

    }
}