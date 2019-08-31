<?php

namespace Differ\Formatters\json;

function render($data)
{
    $arrResult = array_reduce($data, function ($acc, $value) {
        $status = $value['status'];
        $name = $value['name'];
        $oldValue = json_encode($value['oldValue']);
        $newValue = json_encode($value['newValue']);
        $children = $value['children'];

        switch ($status) {
            case 'nested':
                $children = render($value['children']);
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
