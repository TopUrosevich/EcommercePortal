<?php

error_reporting(E_ALL);

//try {

    /**
     * Define some useful constants
     */
    define('BASE_DIR', dirname(__DIR__));
    define('APP_DIR', BASE_DIR . '/app');
    define('SITE_URL','http://52.10.115.114');
    define('BUCKET_URL','https://findmyrice.s3-us-west-2.amazonaws.com');

    define('ADMIN_PROFILE_ID','54c0b1faa740f4fafe2ae26c');
    define('USER_PROFILE_ID','54c0b20ca740f4fafe2ae26d');
    define('COMPANY_PROFILE_ID','54c0b22ba740f4fafe2ae26e');
    define('NEWS_CONTRIBUTOR_PROFILE_ID','54df72e2dd435c45e09d37fb');

	/**
	 * Read the configuration
	 */
	$config = include APP_DIR . '/config/config.php';

	/**
	 * Read auto-loader
	 */
	include APP_DIR . '/config/loader.php';

	/**
	 * Read services
	 */
	include APP_DIR . '/config/services.php';

	$listener = new \Phalcon\Debug();
	$listener->listen();

	/**
	 * Handle the request
	 */
	$application = new \Phalcon\Mvc\Application($di);

	echo $application->handle()->getContent();

//} catch (Exception $e) {
//	echo $e->getMessage(), '<br>';
//	echo nl2br(htmlentities($e->getTraceAsString()));
//}
