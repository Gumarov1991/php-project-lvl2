<?php

namespace Differ\parsers;

use Symfony\Component\Yaml\Yaml;

class Parser
{
    private $pathToFile;
    private $extensionFile;

    public function __construct($file)
    {
        $this->pathToFile = $file[0] === '/' ? $file : __DIR__ . "/{$file}";
        preg_match('/[^\.]+$/', $file, $matches);
        $this->extensionFile = $matches[0];
    }

    public function genArrForMerge()
    {
        if ($this->extensionFile === 'json') {
            return json_decode(file_get_contents($this->pathToFile), true);
        }
        if ($this->extensionFile === 'yaml' || $this->extensionFile === 'yml') {
            return Yaml::parseFile($this->pathToFile);
        }
    }
}
