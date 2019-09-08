<?php

namespace Differ\Formatters\json;

function render($data)
{
    $arrResult = array_reduce($data, function ($acc, $value) {
        $status = $value['status'];
        $name = $value['name'];
        $oldValue = $value['oldValue'];
        $newValue = $value['newValue'];
        $children = $value['children'];
        
        switch ($status) {
            case 'nested':
                $children = render($children);
                $acc["  $name"] = $children;
                break;
            case 'not changed':
                $acc["  $name"] = $oldValue;
                break;
            case 'deleted':
                $acc["- $name"] = $oldValue;
                break;
            case 'added':
                $acc["+ $name"] = $oldValue;
                break;
            case 'changed':
                $acc["+ $name"] = $newValue;
                $acc["- $name"] = $oldValue;
                break;
        }
        return $acc;
    }, []);
    return stripslashes(json_encode($arrResult));
}
