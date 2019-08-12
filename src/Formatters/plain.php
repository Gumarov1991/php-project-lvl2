<?php

namespace Differ\Formatters\plain;

function printing($data, $path = '')
{
    $decoded = isJson($data) ? json_decode($data, true) : $data;
    foreach ($decoded as $key => $value) {
        $keyForPrint = substr($key, 2);
        if ($key[0] === '+' && !array_key_exists("- $keyForPrint", $decoded)) {
            $valueForPrint = is_array($value) ? "'complex value'" : genStringFromBool($value);
            print_r("Property '$path$keyForPrint' was added with value: $valueForPrint\n");
        } elseif ($key[0] === '+' && array_key_exists("- $keyForPrint", $decoded)) {
            $fromValue = $decoded["- $keyForPrint"];
            print_r("Property '$path$keyForPrint' was changed. From '$fromValue' to '$value'\n");
        } elseif ($key[0] === '-') {
            print_r("Property '$path$keyForPrint' was removed\n");
        } elseif ($key[0] === ' ' && is_array($value)) {
            $path .= "$keyForPrint.";
            printing($value, $path);
            $path = '';
        }
    }
}

function isJson($string)
{
    return is_string($string) && is_array(json_decode($string, true)) ? true : false;
}

function genStringFromBool($value)
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    return $value;
}
