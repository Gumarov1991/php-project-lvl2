# Generate diff
[![Build Status](https://travis-ci.org/Gumarov1991/php-project-lvl1.svg?branch=master)](https://travis-ci.org/Gumarov1991/php-project-lvl2)
[![Maintainability](https://api.codeclimate.com/v1/badges/bcde362de2d160e40d48/maintainability)](https://codeclimate.com/github/Gumarov1991/php-project-lvl2/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/bcde362de2d160e40d48/test_coverage)](https://codeclimate.com/github/Gumarov1991/php-project-lvl2/test_coverage)

#### 'Generate diff' is the application for search differeces in configuration files.

### Install
```
curl -sS https://getcomposer.org/installer | php
php composer.phar global require albert1991/php-project-lvl2
```
### Help
```
gendiff -h
```
### Ussage

####### For examples we have 6 files:

[before.json](https://github.com/Gumarov1991/php-project-lvl2/blob/master/tests/fixtures/before.json) //
[after.json](https://github.com/Gumarov1991/php-project-lvl2/blob/master/tests/fixtures/after.json) //
[before.yml](https://github.com/Gumarov1991/php-project-lvl2/blob/master/tests/fixtures/before.yml) //
[after.yml](https://github.com/Gumarov1991/php-project-lvl2/blob/master/tests/fixtures/after.yml) //
[recursiveBefore.json](https://github.com/Gumarov1991/php-project-lvl2/blob/master/tests/fixtures/recursiveBefore.json) //
[recursiveAfter.json](https://github.com/Gumarov1991/php-project-lvl2/blob/master/tests/fixtures/recursiveAfter.json)

[![demo](https://asciinema.org/a/McrdGLRJ5OZkSWkD1Nd56wCo8.svg)](https://asciinema.org/a/McrdGLRJ5OZkSWkD1Nd56wCo8?autoplay=1)