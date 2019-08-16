<?php

namespace Differ\parsers;

use Symfony\Component\Yaml\Yaml;


function genData($pathToFile)
{
    $absolutPath = $pathToFile[0] === '/' ? $pathToFile : __DIR__ . "/{$pathToFile}";
    $file = new \SplFileInfo($pathToFile);
    $extensionFile = $file->getExtension();
    $data = parseFile($absolutPath, $extensionFile);
    return $data;
}

function parseFile($path, $extension)
{
    if ($extension === 'json') {
        $result = getJson($path);
    } elseif ($extension === 'yaml' || $extension === 'yml') {
        $result = Yaml::parseFile($path);
    } else {
        throw new \Exception("Error reading file '{$path}'");
    }
    return $result;
}

function getJson($pathToFile)
{
    return json_decode(file_get_contents($pathToFile), true);
}
