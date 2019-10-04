<?php

use Composer\Autoload\ClassLoader;

$classLoader = new ClassLoader();
$classLoader->setPsr4('Mouf\\Composer\\', ['src/']);

return $classLoader;
