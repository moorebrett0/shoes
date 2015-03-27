<?php
    class Brand
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function getId()
        {
            return $this->id;
        }

        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }

        function save()

        {
           $statement = $GLOBALS['DB']->query("INSERT INTO brands (brand) VALUES ('{$this->getName()}') RETURNING id;");
           $result = $statement->fetch(PDO::FETCH_ASSOC);
           $this->setId($result['id']);
        }

        static function getAll()
        {
            $returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands;");
            $brands = array();
            foreach($returned_brands as $brand){
                $name = $brand['brand'];
                $id = $brand['id'];
                $new_brand = new Brand($name, $id);
                array_push($brands, $new_brand);
            }
            return $brands;

        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands *;");
            $GLOBALS['DB']->exec("DELETE FROM stores_brands WHERE brand_id = {$this->getId()};");
        }

        static function find($search_id)
        {
            $found_brand = null;
            $brands = Brand::getAll();
            foreach($brands as $brand) {
                $brand_id = $brand->getId();
                if ($brand_id == $search_id) {
                    $found_brand = $brand;
                }
            }
            return $found_brand;
        }

        function addStore($store)
        {
            $GLOBALS['DB']->exec("INSERT INTO stores_books (store_id, brand_id) VALUES ({$store->getId()}, {$this->getId()});");
        }

        function getStores()
        {
            $query = $GLOBALS['DB']->query("SELECT store_id FROM stores_brands WHERE brand_id = {$this->getId()};");
            $store_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $stores = array();
            foreach($store_ids as $id) {
                $store_id = $id['store_id'];
                $result = $GLOBALS['DB']->query("SELECT * FROM stores WHERE id = {$store_id};");
                $returned_store = $result->fetchAll(PDO::FETCH_ASSOC);

                $name = $returned_store[0]['name'];
                $id = $returned_store[0]['id'];
                $new_store = new Category($name, $id);
                array_push($stores, $new_store);
            }
            return $stores;
        }
    }
?>
