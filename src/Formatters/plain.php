<?php

namespace Differ\Formatters\plain;

function printing($data, $path = '')
{
    $arrResult = array_reduce($data, function ($acc, $value) use ($path) {
        $status = $value['status'];
        $name = $value['name'];
        $oldValue = genValue($value['oldValue']);
        $newValue = genValue($value['newValue']);
        $children = $value['children'];
        //rint_r($oldValue);
        switch ($status) {
            case 'nested':
                $path .= "$name.";
                $acc[] = printing($value['children'], $path);
                $path = '';
                break;
            case 'deleted':
                $acc[] = "Property '" . $path . $name . "' was removed";
                break;
            case 'added':
                $acc[] = "Property '" . $path . $name . "' was added with value: '$oldValue'";
                break;
            case 'changed':
                $acc[] = "Property '" . $path . $name . "' was changed. From '$oldValue' to '$newValue'";
                break;
        }
        return $acc;
    }, []);
    $strResult = implode("\n", $arrResult);
    return $strResult;
}


function genValue($value)
{
    if (is_array($value)) {
        return "complex value";
    } elseif (is_bool($value)) {
        return $value ? 'true' : 'false';
    } else {
        return $value;
    }
}
