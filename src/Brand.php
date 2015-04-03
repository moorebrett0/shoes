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
            $GLOBALS['DB']->exec("INSERT INTO brands_stores (store_id, brand_id) VALUES ({$store->getId()}, {$this->getId()});");
        }

        function getStores()
        {
            $query = $GLOBALS['DB']->query("SELECT stores.* FROM brands JOIN brands_stores ON (brands.id = brands_stores.brand_id) JOIN stores ON (stores.id = brands_stores.store_id)  WHERE brands.id = {$this->getId()};");
            $store_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $stores = array();
            foreach ($store_ids as $store) {
              $name = $store['name'];
              $id = $store['id'];
              $new_store = new Stores($name, $id);
              array_push($stores, $new_store);
            }
            return $stores;
        }
    }
?>
