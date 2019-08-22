<?php

namespace Differ\parsers;

use Symfony\Component\Yaml\Yaml;


function genData($pathToFile)
{
    $absolutPath = $pathToFile[0] === '/' ? $pathToFile : __DIR__ . "/{$pathToFile}";
    $file = new \SplFileInfo($pathToFile);
    $extensionFile = $file->getExtension();
    return parseFile($extensionFile, $absolutPath);
}

function parseFile($extension, $path)
{
    $mapping = [
        'yml' => function ($path) {
            return Yaml::parseFile($path);
        },
        'json' => function ($path) {
            return json_decode(file_get_contents($path), true);
        }
    ];
    if (isset($mapping[$extension])) {
        return $mapping[$extension]($path);
    } else {
        throw new \Exception("Error reading file '{$path}'");
    }
}
