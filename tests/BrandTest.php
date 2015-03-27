<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Brand.php";
    require_once "src/Stores.php";

    $DB = new PDO('pgsql:host=localhost;dbname=shoes_tests');

    class BrandTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Brand::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Sketchers";
            $id = null;
            $test_brand = new Brand($name, $id);
            //Act
            $result = $test_brand->getName();
            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Sketchers";
            $id = 1;
            $test_brand = new Brand($name, $id);
            //Act
            $result = $test_brand->getId();
            //Assert
            $this->assertEquals(1, $result);
        }

        function test_setId()
        {
            //Arrange
            $name = "Sketchers";
            $id = null;
            $test_brand = new Brand($name, $id);

            //Act
            $test_brand->setId(2);

            //Assert
            $result = $test_brand->getId();
            $this->assertEquals(2, $result);
        }
        //needs getall to work properly
        function test_save()
        {
            //Arrange
            $name = "Sketchers";
            $id = 1;
            $test_brand = new Brand($name, $id);
            $test_brand->save();

            //Act
            $result = Brand::getAll();

            //Assert

            $this->assertEquals($test_brand, $result[0]);
        }

        function test_getAll()
        {
            $name = "Sketchers";
            $id = 1;
            $name2 = 'John Madden';
            $id2 = 2;
            $test_brand = new Brand($name, $id);
            $test_brand->save();
            $test_brand2 = new Brand($name2, $id2);
            $test_brand2->save();

            //Act
            $result = Brand::getAll();

            //Assert
            $this->assertEquals([$test_brand, $test_brand2], $result);
        }

      function test_deleteAll()
      {
          $name = "Sketchers";
          $id = 1;
          $name2 = 'John Madden';
          $id2 = 2;
          $test_brand = new Brand($name, $id);
          $test_brand->save();
          $test_brand2 = new Brand($name2, $id2);
          $test_brand2->save();

          //Act
          Brand::deleteAll();

          //Assert
          $result = Brand::getAll();
          $this->assertEquals([], $result);
      }

      function test_find()
      {
          $name = "Sketchers";
          $id = 1;
          $name2 = 'John Madden';
          $id2 = 2;
          $test_brand = new Brand($name, $id);
          $test_brand->save();
          $test_brand2 = new Brand($name2, $id2);
          $test_brand2->save();

          //Act
          $result = Brand::find($test_brand->getId());

          //Assert
          $this->assertEquals($test_brand, $result);
      }
      function test_addStore()

      {
          //Arrange
          $name = "adidas";
          $id = 1;
          $test_store = new Stores($name, $id);
          $test_store->save();

          $storename = "target";
          $id2 = 2;
          $test_brand = new Brand($brandname, $id2);
          $test_brand->save();

          //Act
          $test_store->addBrand($test_brand);

          //Assert
          $this->assertEquals($test_store->getBrands(), [$test_brand]);
      }

      function test_getStores()

      {
          //Arrange
          $name = "Target";
          $id = 1;
          $test_store = new Stores($name, $id);
          $test_store->save();

          $name2 = "Sketchers";
          $id2 = 2;
          $test_brand = new Brand($name2, $id2);
          $test_brand->save();

          $name3 = "Vans";
          $id3 = 3;
          $test_brand2 = new Brand($name3, $id3);
          $test_brand2->save();

          //Act
          $test_store->addBrand($test_brand);
          $test_store->addBrand($test_brand2);

          //Assert

          $this->assertEquals([$test_brand, $test_brand2], $test_store->getBrands());
      }

    }

?>
