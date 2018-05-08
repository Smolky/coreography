#!/usr/bin/env php
<?php
/**
 * CoreOGraphy
 *
 * This is just a simple PHP framework for custom purposes
 *
 * @author José Antonio García Díaz <joseantonio.garcia8@um.es>
 *
 * @package Core-o-Graphy
 */

// Require vendor
require_once __DIR__ . '/core/bootstrap.php';


// Import namespaces
use Symfony\Component\Console\Application;
use CoreOGraphy\Command\i18nCommand;


/** @var $application Application */
$application = new Application ();


// Attach commands
$application->add (new i18nCommand ());


// Start the application
$application->run ();