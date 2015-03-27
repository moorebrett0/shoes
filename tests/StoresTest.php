<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Stores.php";

    $DB = new PDO('pgsql:host=localhost;dbname=shoes_tests');

    class CategoryTest extends PHPUnit_Framework_TestCase
    {
        function test_getName()
        {
            //Arrange
            $name = "Macy's";
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
            $name = "Macy's";
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
            $name = "Macy's";
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
            $name = "Macy's";
            $id = null;
            $test_store = new Stores($name, $id);
            $test_store->save();

            //Act
            $result = Stores::getAll();

            //Assert

            $this->assertEquals($test_store, $result[0]);
        }
    }
