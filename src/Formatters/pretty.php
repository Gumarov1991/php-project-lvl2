<?php

namespace Differ\Formatters\pretty;

function printing($value, $key = "", $countSpacesForIndent = 0)
{
    $decoded = isJson($value) ? json_decode($value, true) : $value;
    $indent = genIndentForPrinting($countSpacesForIndent);
    if (is_array($decoded)) {
        print_r("$indent$key: {\n");
        foreach ($decoded as $key => $value) {
            printing($value, $key, $countSpacesForIndent + 4);
        }
        print_r("$indent  }\n");
    } else {
        $string = genStringFromBool($decoded);
        print_r("$indent$key: $string\n");
    }
}

function isJson($string)
{
    return is_string($string) && is_array(json_decode($string, true)) ? true : false;
}

function genIndentForPrinting($count)
{
    $result = '';
    for ($i = 0; $i < $count; $i++) {
        $result .= ' ';
    }
    return $result;
}

function genStringFromBool($value)
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    return $value;
}
