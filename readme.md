Description

This app allows users to keep track of local shoe stores and the brands they stock, using Postgres SQL for the back-end and Silex/Twig for the front-end. For example:

A user can keep track of all local shoe stores by entering a store's name and address.

A user can keep track of all brands sold by stores by simply providing a brand name. From here, the user should be able to assign brands to a store, so others can know who offers what.

Setup instructions

Clone this git repository
Set your localhost root folder to ~/shoes/web/
Ensure PHP server is running.
Start Postgres and import shoes.sql database into a new database shoes 4b. Do the same for the test database: shoes_test.sql
Use Composer to install required dependencies in the composer.json file
Start the web app by pointing your browser to the root (http://localhost:8000/)





PSQL COMMANDS

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
