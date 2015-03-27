<?php
    //linking to src file
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stores.php";
    require_once __DIR__."/../src/Brand.php";
    $app = new Silex\Application();
    $DB = new PDO('pgsql:host=localhost;dbname=to_do');
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();
    $app['debug']=TRUE;
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.twig');
    });
