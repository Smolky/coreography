<?php

use Pimple\Container;
use Symfony\Component\Debug\Debug;


/**
 * This file is the bootstrap of the application. This file 
 * has to be called for all entry points of the application 
 * such as a web controller, cli, etc.
 *
 * @author José Antonio García Díaz <joseantonio.garcia8@um.es>
 *
 * @package Core-o-Graphy
 */


// Require vendor
require_once __DIR__ . '/../vendor/autoload.php';


// Require configuration
require_once __DIR__ . '/../config.php';


// Constants
define ('PRODUCTION', $production);
define ('BASE_URL', $base_url);
define ('VERSION', 0.1);
define ('CACHE_DIR', __DIR__ . '/../cache/');


// Set the error level based on the stage
if (PRODUCTION) {
    error_reporting (0);
    ini_set ('display_errors', 0);
    
} else {
    ini_set ('display_errors', 1);
    ini_set ('display_startup_errors', 1);
    error_reporting (E_ALL); 
    Debug::enable ();
}


// Dependency container
$container = new Container ();


// Require core libs
require_once __DIR__ . '/../core/functions.php';


// Database connection
// Database info is stored at config.php
if ($user) {
    $database = new \CoreOGraphy\Database ($dsn, $user, $password);
    $container['connection'] = $database;
    $container['pdo'] = $database->connect ();
}


// Configure the transform layer
$transport = Swift_SmtpTransport::newInstance ($email_server, $email_port, $email_protocol)
    ->setUsername ($email_username)
    ->setPassword ($email_password)
    ->setStreamOptions (array ('ssl' => array ('allow_self_signed' => true, 'verify_peer' => false)))
;

$container['transport'] = $transport;



// Translations
$i18n = new i18n ();
$i18n->setCachePath ('./cache/lang');
$i18n->setFilePath ('./lang/lang_{LANGUAGE}.json');
$i18n->setFallbackLang ('en');
$i18n->setPrefix ('I');
$i18n->setSectionSeperator ('_');
$i18n->init ();

$container['i18n'] = $i18n;


// Start session
session_start ();