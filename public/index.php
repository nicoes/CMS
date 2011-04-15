<?php
/*
 * Defines the directory separator for windows or unix env
 */
define('DS', DIRECTORY_SEPARATOR);

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . DS . '..'. DS .'application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

define('ZEND_LIBRARY_PATH', realpath(APPLICATION_PATH . '/../library/Zend'));
define('ZENDX_LIBRARY_PATH', realpath(APPLICATION_PATH . '/../library/ZendX'));
define('APP_LIBRARY_PATH', realpath(APPLICATION_PATH . '/library'));

$paths = array(
    realpath(APPLICATION_PATH . DS .'..'. DS .'library'),
    APP_LIBRARY_PATH,
	ZEND_LIBRARY_PATH,
	ZEND_LIBRARY_PATH,
	get_include_path()
);

/**
 * Set the include paths to point to the new defined paths
 */
set_include_path(implode(PATH_SEPARATOR, $paths));

/** Zend_Application */
require_once 'Zend'. DS .'Application.php';  

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV, 
    APPLICATION_PATH  . DS .'configs'. DS .'application.ini'
);
$application->bootstrap()
            ->run();