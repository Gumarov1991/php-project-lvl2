<?php

namespace Differ\Formatters\pretty;

use Funct\Collection;

const TAB_INDENT = 4;
const FIRST_INDENT = 2;

function render($data, $countSpacesIndent = 0)
{
    $arrResult = array_reduce($data, function ($acc, $value) use ($countSpacesIndent) {
        $indent = str_repeat(' ', $countSpacesIndent + FIRST_INDENT);
        $status = $value['status'];
        $name = $value['name'];
        $oldValue = genValue($value['oldValue'], $countSpacesIndent);
        $newValue = genValue($value['newValue'], $countSpacesIndent);
        $children = $value['children'];
        
        switch ($status) {
            case 'nested':
                $acc[] = $indent . "  " . $name . ": " . render($value['children'], $countSpacesIndent + TAB_INDENT);
                break;
            case 'not changed':
                $acc[] = $indent . "  " . $name . ": " . $oldValue;
                break;
            case 'deleted':
                $acc[] = $indent . "- " . $name . ": " . $oldValue;
                break;
            case 'added':
                $acc[] = $indent . "+ " . $name . ": " . $oldValue ;
                break;
            case 'changed':
                $acc[] = $indent . "+ " . $name . ": " . $newValue;
                $acc[] = $indent . "- " . $name . ": " . $oldValue;
                break;
        }
        return $acc;
    }, []);

    $indent = str_repeat(' ', $countSpacesIndent);
    $strResult = "{\n" . implode("\n", $arrResult) . $indent . "\n" . $indent . "}";
    return $strResult;
}

function genValue($value, $countSpacesIndent)
{
    if (is_array($value)) {
        $key = key($value);
        $firstIndent = str_repeat(' ', $countSpacesIndent + TAB_INDENT * 2);
        $lastIndent = str_repeat(' ', $countSpacesIndent + FIRST_INDENT);
        return "{\n" . $firstIndent . $key . ": " . $value[$key] . "\n" . $lastIndent . "  }";
    } elseif (is_bool($value)) {
        return $value ? 'true' : 'false';
    } elseif (is_int($value)) {
        return $value;
    } else {
        return $value;
    }
}
