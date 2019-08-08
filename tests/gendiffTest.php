<?php

namespace Differ\tests\gendiffTest;

use Differ\tests\fixtures\resultTest\Result;
use function Differ\genDiff;
use PHPUnit\Framework\TestCase;

class GenDiff extends TestCase
{
    public function testGendiff()
    {
        $this->assertEquals(Result::RESULT1, genDiff('../tests/fixtures/before.json', '../tests/fixtures/after.json'));
    }
}
