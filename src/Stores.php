<?php
    class Stores
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
           $statement = $GLOBALS['DB']->query("INSERT INTO stores (name) VALUES ('{$this->getName()}') RETURNING id;");
           $result = $statement->fetch(PDO::FETCH_ASSOC);
           $this->setId($result['id']);
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE stores SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        static function getAll()
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
            $stores = array();
            foreach($returned_stores as $store){
                $name = $store['name'];
                $id = $store['id'];
                $new_store = new Stores($name, $id);
                array_push($stores, $new_store);
            }
            return $stores;
        }

        static function deleteAll()
       {
           $GLOBALS['DB']->exec("DELETE FROM stores *;");
       }

       static function find($search_id)
        {
            $found_store = null;
            $stores = Stores::getAll();
            foreach($stores as $store){
                $store_id = $store->getId();
                if ($store_id == $search_id) {
                    $found_store = $store;
                }
            }
            return $found_store;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM stores_brands WHERE store_id = {$this->getId()};");

        }

        function addBrand($brand)
        {
            $GLOBALS['DB']->exec("INSERT INTO stores_brands (store_id, brand_id) VALUES ({$this->getId()}), {$brand->getId()};");
        }

        function getBrands()
        {
            $query = $GLOBALS['DB']->query("SELECT brands.* FROM stores JOIN stores_brands ON stores.id = stores_brands.store_id JOIN brands ON brands.id = stores_brands.brand_id  WHERE stores.id = {$this->getId()};");
            $brand_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $brands = array();
            foreach($brand_ids as $id) {
                $brand_id = $id['brand_id'];
                $result = $GLOBALS['DB']->query("SELECT * FROM brands WHERE id = {$brand_id};");
                $returned_brand = $result->fetchAll(PDO::FETCH_ASSOC);

                $name = $returned_brand[0]['brand'];
                $id = $returned_brand[0]['id'];
                $new_brand = new Brand($name, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }


    }


?>
