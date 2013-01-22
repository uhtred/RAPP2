<?php
/**
 *   Master Config
 */
define('BASE_URL', '/{base url}');
define('DB_NAME', '{db name}');
define('DB_USER', '{db user}');
define('DB_PASS', '{db pass}');


require 'Slim/Slim.php';

// Paris and Idiorm
require 'Paris/idiorm.php';
require 'Paris/paris.php';

/**
 *   Models
 */
require 'models/Article.php';


/**
 *   Database Config
 */
ORM::configure('mysql:host=localhost;dbname=' . DB_NAME);
ORM::configure('username', DB_USER);
ORM::configure('password', DB_PASS);


\Slim\Slim::registerAutoloader();

require 'Slim/Extras/Views/Twig.php';

use Slim\Slim;

use Slim\Extras\Views\Twig as Twig;

// Start Slim.
$app = new Slim(array(

    'view' => new Twig

));

/**
 *   Hooks
 */

$app->hook('slim.before', function () use ($app) {
    $app->view()->appendData(array('baseUrl' => BASE_URL));
});

/**
 *   Routes
 */

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
 * Run Application
 */
$app->run();
