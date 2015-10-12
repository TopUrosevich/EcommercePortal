<?php
$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerNamespaces(array(
    'Findmyrice\Models' => $config->application->modelsDir,
    'Findmyrice\Controllers' => $config->application->controllersDir,
    'Findmyrice\Forms' => $config->application->formsDir,
    'Findmyrice' => $config->application->libraryDir
));

$loader->register();
// Use composer autoloader to load vendor classes
require_once __DIR__ . '/../vendor/autoload.php';
