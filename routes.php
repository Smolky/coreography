<?php

// Home page
$router->map ('GET', '/', function () {

    // Load the classifier page
    require __DIR__ . '/controllers/maintenance/NotFound404.php';
    return new NotFound404 ();
    
});


// Login
$router->map ('GET|POST', '/login', function () {

    // To the home page, the user must be logged
    require __DIR__ . '/controllers/login/Index.php';
    return new Index ();
    
});


// Register
$router->map ('GET|POST', '/register', function () {

    // To the home page, the user must be logged
    require __DIR__ . '/controllers/register/Index.php';
    return new Index ();
    
});

// Logout
$router->map ('GET', '/logout', function () { 

    global $base_url;

    // Destroy session
    session_destroy();

    
    // Reload
    header ('Location: ' . $base_url);
    die ();
    
});