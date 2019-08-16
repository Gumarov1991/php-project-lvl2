<?php

namespace Differ\Formatters\json;

function genRender($data)
{
    $arrResult = array_reduce($data, function ($acc, $value) {
        $status = $value['status'];
        $name = $value['name'];
        $oldValue = genValue($value['oldValue']);
        $newValue = genValue($value['newValue']);
        $children = $value['children'];

        switch ($status) {
            case 'nested':
                $children = genRender($value['children']);
                $acc[] = "\"  $name\"" . ": " . $children;
                break;
            case 'not changed':
                $acc[] = "\"  $name\"" . ": " . $oldValue;
                break;
            case 'deleted':
                $acc[] = "\"- $name\"" . ": " . $oldValue;
                break;
            case 'added':
                $acc[] = "\"+ $name\"" . ": " . $oldValue;
                break;
            case 'changed':
                $acc[] = "\"+ $name\"" . ": " . $newValue;
                $acc[] = "\"- $name\"" . ": " . $oldValue;
                break;
        }
        return $acc;
    }, []);
    $strResult = "{" . implode(',', $arrResult) . "}";
    return $strResult;
}

function genValue($value)
{
    if (is_array($value)) {
        $key = key($value);
        return "{" . "\"$key\"" . ": " . "\"$value[$key]\"" . "}";
    } elseif (is_bool($value)) {
        return $value ? 'true' : 'false';
    } elseif (is_int($value)) {
        return $value;
    } else {
        return "\"$value\"";
    }
}
