<?php
    //linking to src file
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stores.php";
    require_once __DIR__."/../src/Brand.php";
    $app = new Silex\Application();

    $DB = new PDO('pgsql:host=localhost;dbname=shoes');

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app['debug']=TRUE;

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.twig');
    });
    //READ ALL BRANDS
    $app->get("/brands", function() use ($app) {
            return $app['twig']->render('brands.twig', array('brands' => Brand::getAll()));
    });

    //READ ALL STORES
    $app->get("/stores", function() use ($app) {
        return $app['twig']->render('stores.twig', array('stores' => Stores::getAll()));
    });

    //READ singular store
   $app->get("/stores/{id}", function($id) use ($app) {
     $store = Stores::find($id);
     return $app['twig']->render('store.twig', array('store' => $store,
       'brands' => $store->getBrands(), 'all_brands' => Brand::getAll()));
   });

   //READ singular brand
   $app->get("/brands/{id}", function($id) use ($app) {
         $brand = Brand::find($id);
         return $app['twig']->render('brand.twig', array('brand' => $brand, 'stores' =>
             $brand->getStores(), 'all_stores' => Stores::getAll()));
    });

     //EDIT a store
     $app->get("/stores/{id}/edit", function($id) use ($app) {
          $store = Stores::find($id);
          return $app['twig']->render('stores_edit.twig', array('store' => $store));
      });

      //CREATE Store
      $app->post("/stores", function() use ($app) {
         $store = new Stores($_POST['name'], $id = null);
         $store->save();
         return $app['twig']->render('stores.twig', array('stores' => Stores::getAll()));
    });
    //CREATE BRAND
    $app->post("/brands", function() use ($app) {
        $name = $_POST['brand'];
        $brand = new Brand($name);
        $brand->save();
        return $app['twig']->render('brands.twig', array('brands' => Brand::getAll()));
    });
    //CREATE add brand to stores
    $app->post("/add_brands", function() use ($app) {
       $store = Stores::find($_POST['store_id']);
       $brand = Brand::find($_POST['brand_id']);
       $store->addBrand($brand);
       return $app['twig']->render('store.twig', array('store' => $store, 'stores' => Stores::getAll(),
           'brands' => $store->getBrands(), 'all_brands' => Brand::getAll()));
   });
   //CREATE add stores to brand
   $app->post("/add_stores", function() use ($app) {
        $store = Stores::find($_POST['store_id']);
        $brand = Brand::find($_POST['brand_id']);
        $brand->addStore($store);
        return $app['twig']->render('brand.twig', array('brand' => $brand, 'brands' => Brand::getAll(),
            'stores' => $brand->getStores(), 'all_stores' => Stores::getAll()));
    });

    //DELETE all brands
    $app->post("/delete_brands", function() use ($app) {
        Brand::deleteAll();
        return $app['twig']->render('index.twig');
    });


    //DELETE all stores
    $app->post("/delete_stores", function() use ($app) {
        Stores::deleteAll();
        return $app['twig']->render('index.twig');
    });

    //DELETE singular store
    $app->delete("/stores/{id}", function($id) use ($app) {
        $store = Stores::find($id);
        $store->delete();
        return $app['twig']->render('index.twig', array('stores' => Stores::getAll()));
    });

    //PATCH ROUTES for stores
    $app->patch("/stores/{id}", function($id) use ($app) {
        $name = $_POST['name'];
        $store = Stores::find($id);
        $store->update($name);
        return $app['twig']->render('store.twig', array('store' => $store, 'brands' =>
            $store->getBrands(), 'all_brands' => Brand::getAll()));
    });

    return $app;

?>
