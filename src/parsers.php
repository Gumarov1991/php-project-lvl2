<?php

namespace Differ\parsers;

use Symfony\Component\Yaml\Yaml;


function genData($pathToFile)
{
    $absolutPath = $pathToFile[0] === '/' ? $pathToFile : __DIR__ . "/{$pathToFile}";
    $extensionFile = pathinfo($absolutPath, PATHINFO_EXTENSION);
    if (file_exists($absolutPath)) {
        $contentFile = file_get_contents($absolutPath);
        return parse($contentFile, $extensionFile);
    }
    throw new \Exception("The '{$pathToFile}' doesn't exists");
}

function parse($data, $extension)
{
    $mapping = [
        'yml' => function ($data) {
            return Yaml::parse($data);
        },
        'json' => function ($data) {
            return json_decode($data, true);
        }
    ];
    if (isset($mapping[$extension])) {
        return $mapping[$extension]($data);
    }
    throw new \Exception("The '.{$extensionFile}' extension is not supported");
}
