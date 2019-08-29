<?php

namespace Differ\parsers;

use Symfony\Component\Yaml\Yaml;

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
    throw new \Exception("The '.{$fileExtension}' extension is not supported");
}
