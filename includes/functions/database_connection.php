<?php
if (!function_exists('pdo_connect_hash')) {
    function pdo_connect_hash() {
		//$hostname = "madisonh3.db.9551128.hostedresource.com";
        $username = 'paramireze';
        $password = '212121sasa';
        $database = 'madisonhash';
        $dsn = 'mysql:host=mysql.madisonh3.com; dbname='.$database;
       
        try {
                $connection = new PDO($dsn, $username, $password);
        } catch (Exception $e) {
                
        }
        return $connection;
    }
}


?>