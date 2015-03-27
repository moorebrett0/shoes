<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Brand.php";

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
            $test_store = new Brand($name, $id);
            //Act
            $result = $test_store->getName();
            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Sketchers";
            $id = 1;
            $test_store = new Brand($name, $id);
            //Act
            $result = $test_store->getId();
            //Assert
            $this->assertEquals(1, $result);
        }

        function test_setId()
        {
            //Arrange
            $name = "Sketchers";
            $id = null;
            $test_store = new Brand($name, $id);

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
            $name = "Sketchers";
            $id = 1;
            $test_store = new Brand($name, $id);
            $test_store->save();

            //Act
            $result = Brand::getAll();

            //Assert

            $this->assertEquals($test_store, $result[0]);
        }

    }

?>
