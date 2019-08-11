<?php

namespace Differ\tests\fixtures;

class DataTest
{
    const FILE_JSON_1 = '../tests/fixtures/before.json';
    const FILE_JSON_2 = '../tests/fixtures/after.json';
    const RESULT_JSON = '{"  host":"hexlet.io","+ timeout":20,"- timeout":50,"- proxy":"123.234.53.22","+ verbose":true}';

    const FILE_YAML_1 = '../tests/fixtures/before.yml';
    const FILE_YAML_2 = '../tests/fixtures/after.yml';
    const RESULT_YAML = '{"  host":"hexlet.io","+ timeout":20,"- timeout":50,"- proxy":"123.234.53.22","+ verbose":true}';

    const FILE_R_JSON_1 = '../tests/fixtures/recursiveBefore.json';
    const FILE_R_JSON_2 = '../tests/fixtures/recursiveAfter.json';
    const RESULT_R_JSON = '{"  common":{"  setting1":"Value 1","- setting2":"200","  setting3":true,"- setting6":{"  key":"value"},"+ setting4":"blah blah","+ setting5":{"  key5":"value5"}},"  group1":{"+ baz":"bars","- baz":"bas","  foo":"bar"},"- group2":{"  abc":"12345"},"+ group3":{"  fee":"100500"}}';
}
