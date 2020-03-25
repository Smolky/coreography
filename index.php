<?php

use \Twig\Loader\FilesystemLoader;
use \Twig\Environment;
use \Twig\TwigFunction;

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



/**
 * @var $twig_configuration Array
 *
 * Create and configure the template system
 *
 * @link http://whateverthing.com/blog/2015/02/17/twig-tips-configuring-cache/
 */
$twig_configuration = [];

if (PRODUCTION) {
    $twig_configuration = [
        'cache'       => CACHE_DIR . 'templates',
        'auto_reload' => true
    ];
}


/** @var $loader Twig_Loader_Filesystem Where the templates are stored */
$loader = new FilesystemLoader ('templates');


/** @var $twig Environment Twig global object */
$twig = new Environment ($loader, $twig_configuration);


// Add global variables to the template
$twig->addGlobal ('base_url', BASE_URL);
$twig->addGlobal ('version', PRODUCTION ? VERSION : rand (1, 10000));


// Store the template system as a service
$container['loader'] = $loader;
$container['templates'] = $twig;


// If translations services are loaded, then 
// attach it to TWIG as a helper function
if ($container['i18n']) {
    
    $twig->addFunction (new TwigFunction ('__', function ($method) {
        try {
            return call_user_func ('I' . '::' . $method); 
            
        } catch (Exception $e) {
            return '';
        }
    }));
}



/** @var $router AltoRouter The service that resolves routes */
$router = new AltoRouter ();


// Configure the basepath of the routes
$router->setBasePath (ltrim (BASE_URL, '/'));


// Store the routing system as a service
$container['router'] = $router;


// Attach routes
require_once __DIR__ . '/routes.php';


/** @var $match callable match current request URL */
$match = $router->match ();


// Determine which controller will handle the current route
if ($match && is_callable ($match['target'])) {
    $controller = call_user_func_array ($match['target'], $match['params']);
    
} else {

    // No controller was found, using a 404 controller
    require __DIR__ . '/controllers/maintenance/NotFound404.php';
    $controller = new NotFound404 ();
    
}


// Handle the controller
echo $controller->handle ();
