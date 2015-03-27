<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Stores.php";

    $DB = new PDO('pgsql:host=localhost;dbname=shoes_tests');

    class StoresTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Stores::deleteAll();
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
        }
    }
?>
