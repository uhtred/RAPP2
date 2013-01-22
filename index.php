<?php

define('BASE_URL', '/Projetos/RAPP2');

/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
require 'Slim/Slim.php';

// Paris and Idiorm
require 'Paris/idiorm.php';
require 'Paris/paris.php';

// Models
require 'models/Article.php';

// Configuration
ORM::configure('mysql:host=localhost;dbname=blog');
ORM::configure('username', 'root');
ORM::configure('password', '120608');


\Slim\Slim::registerAutoloader();

require 'Slim/Extras/Views/Twig.php';

use Slim\Slim;

use Slim\Extras\Views\Twig as Twig;

// Start Slim.
$app = new Slim(array(

    'view' => new Twig

));

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, and `Slim::delete`
 * is an anonymous function.
 */

$app->hook('slim.before', function () use ($app) {
    $app->view()->appendData(array('baseUrl' => BASE_URL));
});

// GET route
$app->get('/', function () use($app) {

    $articles = Model::factory('Article')
                    ->order_by_desc('timestamp')
                    ->find_many();
                    
     $app->render('home.html', array('articles' => $articles));
     
});

// POST route
$app->post('/post', function () {
    echo 'This is a POST route';
});

// PUT route
$app->put('/put', function () {
    echo 'This is a PUT route';
});

// DELETE route
$app->delete('/delete', function () {
    echo 'This is a DELETE route';
});

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
