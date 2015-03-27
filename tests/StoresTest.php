<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Stores.php";
    require_once "src/Brand.php";

    $DB = new PDO('pgsql:host=localhost;dbname=shoes_tests');

    class StoresTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Stores::deleteAll();
            Brand::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Macys";
            $id = null;
            $test_store = new Stores($name, $id);
            //Act
            $result = $test_store->getName();
            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Macys";
            $id = 1;
            $test_store = new Stores($name, $id);
            //Act
            $result = $test_store->getId();
            //Assert
            $this->assertEquals(1, $result);
        }

        function test_setId()
        {
            //Arrange
            $name = "Macys";
            $id = null;
            $test_store = new Stores($name, $id);

            //Act
            $test_store->setId(2);

            //Assert
            $result = $test_store->getId();
            $this->assertEquals(2, $result);
        }
        //needs getall to work properly
        function test_save()
        {
            //Arrange
            $name = "Macys";
            $id = 1;
            $test_store = new Stores($name, $id);
            $test_store->save();

            //Act
            $result = Stores::getAll();

            //Assert

            $this->assertEquals($test_store, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
           $name = "Macys";
           $id = 1;
           $name2 = 'Nordstrom';
           $id2 = 2;
           $test_store = new Stores($name, $id);
           $test_store->save();
           $test_store2 = new Stores($name2, $id2);
           $test_store2->save();

           //Act
           $result = Stores::getAll();

           //Assert
           $this->assertEquals([$test_store, $test_store2], $result);

        }

        function test_deleteAll()
        {
            //Arrange
           $name = "Macys";
           $id = 1;
           $name2 = 'Nordstrom';
           $id2 = 2;
           $test_store = new Stores($name, $id);
           $test_store->save();
           $test_store2 = new Stores($name2, $id2);
           $test_store2->save();

           //Act
           Stores::deleteAll();
           $result = Stores::getAll();

           //Assert
           $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Macys";
            $id = 1;
            $name2 = 'Nordstrom';
            $id2 = 2;
            $test_store = new Stores($name, $id);
            $test_store->save();
            $test_store2 = new Stores($name2, $id2);
            $test_store2->save();

            //Act
            $result = Stores::find($test_store->getId());

            //Assert
            $this->assertEquals($test_store, $result);

        }

        function test_update()
        {
            //Arrange
            $name = "Macys";
            $id = null;
            $test_store = new Stores($name, $id);
            $test_store->save();

            $new_name = "Target";

            //Act
            $test_store->update($new_name);

            //Assert
            $this->assertEquals("Target", $test_store->getName());
        }

        function test_addBrand()

        {
            //Arrange
            $name = "Nordstrom";
            $id = 1;
            $test_store = new Stores($name, $id);
            $test_store->save();

            $brandname = "adidas";
            $id2 = 2;
            $test_brand = new Brand($brandname, $id2);
            $test_brand->save();

            //Act
            $test_store->addBrand($test_brand);

            //Assert
            $this->assertEquals($test_store->getBrands(), [$test_brand]);
        }

        function test_getBrands()

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

            $this->assertEquals($test_store->getBrands(), [$test_brand, $test_brand2]);
        }
    }
?>
