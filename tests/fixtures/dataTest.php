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
    //const RESULT_R_JSON = 
}
