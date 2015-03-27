Guest=# CREATE DATABASE shoes;
CREATE DATABASE
Guest=# \c shoes;
You are now connected to database "shoes" as user "Guest".
shoes=# CREATE TABLE stores (id serial PRIMARY KEY, name varchar);
CREATE TABLE
shoes=# CREATE TABLE brands (id serial PRIMARY KEY, brand varchar);
CREATE TABLE
shoes=# CREATE TABLE stores_brands (id serial PRIMARY KEY, store_id int, brand_id int);
CREATE TABLE
shoes=# CREATE DATABASE shoes_tests WITH TEMPLATE shoes;
CREATE DATABASE
shoes=#
SELECT brands.* FROM stores JOIN stores_brands ON stores.id = stores_brands.store_id JOIN brands ON brands.id = stores_brands.brand_id  WHERE stores.id = {$this->getId()};
