<?php

namespace Differ\tests\fixtures;

const FILE_JSON_1 = '../tests/fixtures/before.json';
const FILE_JSON_2 = '../tests/fixtures/after.json';
const FILE_YAML_1 = '../tests/fixtures/before.yml';
const FILE_YAML_2 = '../tests/fixtures/after.yml';
const FILE_R_JSON_1 = '../tests/fixtures/recursiveBefore.json';
const FILE_R_JSON_2 = '../tests/fixtures/recursiveAfter.json';

const RESULT_JSON_PRETTY = <<<'result'
{
    host: hexlet.io
  + timeout: 20
  - timeout: 50
  - proxy: 123.234.53.22
  + verbose: true
}
result;

const RESULT_YAML_JSON = '{"  host": "hexlet.io","+ timeout": 20,"- timeout": 50,"- proxy": "123.234.53.22","+ verbose": true}';

const RESULT_R_JSON_PRETTY = <<<'result'
{
    common: {
        setting1: Value 1
      - setting2: 200
        setting3: true
      - setting6: {
            key: value
        }
      + setting4: blah blah
      + setting5: {
            key5: value5
        }    
    }
    group1: {
      + baz: bars
      - baz: bas
        foo: bar    
    }
  - group2: {
        abc: 12345
    }
  + group3: {
        fee: 100500
    }
}
result;

const RESULT_R_JSON_PLAIN = <<<'result'
Property 'common.setting2' was removed
Property 'common.setting6' was removed
Property 'common.setting4' was added with value: 'blah blah'
Property 'common.setting5' was added with value: 'complex value'
Property 'group1.baz' was changed. From 'bas' to 'bars'
Property 'group2' was removed
Property 'group3' was added with value: 'complex value'
result;
