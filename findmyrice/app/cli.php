<?php

use Phalcon\DI\FactoryDefault\CLI as CliDI,
    Phalcon\CLI\Console as ConsoleApp;

define('VERSION', '1.3.4');

//Using the CLI factory default services container
$di = new CliDI();

// Define path to application directory
defined('APPLICATION_PATH')
|| define('APPLICATION_PATH', realpath(dirname(__FILE__)));

defined('APP_DIR')
|| define('APP_DIR', realpath(dirname(__FILE__)));

// Load the configuration file (if any)
if(is_readable(APPLICATION_PATH . '/config/config.php')) {
    $config = include APPLICATION_PATH . '/config/config.php';
    $di->set('config', $config);
}

/**
 * Register the autoloader and tell it to register the tasks directory
 */
$loader = new \Phalcon\Loader();
$loader->registerDirs(
    array(
        APPLICATION_PATH . '/tasks'
    )
);
$loader->registerNamespaces(array(
    'Findmyrice\Models' => $config->application->modelsDir,
    'Findmyrice\Controllers' => $config->application->controllersDir,
    'Findmyrice\Forms' => $config->application->formsDir,
    'Findmyrice' => $config->application->libraryDir
));

$loader->register();

// Router
$di->setShared('router', function() {
    return new Phalcon\CLI\Router();
});

// Dispatcher
$di->setShared('dispatcher', function() {
    return new Phalcon\CLI\Dispatcher();
});

//Register the mongo db connection in the DI
$di->set('mongo', function() {
//	$mongo = new Mongo("mongodb://localhost");
    $mongo = new MongoClient();
    return $mongo->selectDB('findmyrice');
});

//Register a collection manager
$di->set('collectionManager', function() {
    return new Phalcon\Mvc\Collection\Manager();
});

//Create a console application
$console = new ConsoleApp();
$console->setDI($di);

/**
 * Process the console arguments
 */
$arguments = array();
foreach($argv as $k => $arg) {
    if($k == 1) {
        $arguments['task'] = $arg;
    } elseif($k == 2) {
        $arguments['action'] = $arg;
    } elseif($k >= 3) {
      $arguments['params'][] = $arg;
    }
}

// define global constants for the current task and action
define('CURRENT_TASK', (isset($argv[1]) ? $argv[1] : null));
define('CURRENT_ACTION', (isset($argv[2]) ? $argv[2] : null));

try {
    // handle incoming arguments
    $console->handle($arguments);
}
catch (\Phalcon\Exception $e) {
    echo $e->getMessage();
    exit(255);
}