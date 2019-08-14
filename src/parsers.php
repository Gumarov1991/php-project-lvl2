<?php

namespace Differ\parsers;

use Symfony\Component\Yaml\Yaml;


function genArr($pathToFile)
{
    $absolutPath = $pathToFile[0] === '/' ? $pathToFile : __DIR__ . "/{$pathToFile}";
    $extensionFile = getExtesion($pathToFile);
    if ($extensionFile === 'json') {
        return json_decode(file_get_contents($absolutPath), true);
    }
    if ($extensionFile === 'yaml' || $extensionFile === 'yml') {
        return Yaml::parseFile($absolutPath);
    }
}

function getExtesion($pathToFile)
{
    preg_match('/[^\.]+$/', $pathToFile, $matches);
    return $matches[0];
}
