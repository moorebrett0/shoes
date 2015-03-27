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
            $test_category = new Stores($name, $id);
            //Act
            $result = $test_category->getName();
            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Macy's";
            $id = 1;
            $test_category = new Stores($name, $id);
            //Act
            $result = $test_category->getId();
            //Assert
            $this->assertEquals(1, $result);
        }
    }
