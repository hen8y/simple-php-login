
<?php
    define('USER', 'xx');
    define('PASSWORD', 'xx');
    define('HOST', 'localhost');
    define('DATABASE', 'xx');
    try {
        $link = new PDO("mysql:host=".HOST.";dbname=".DATABASE, USER, PASSWORD);
    } catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    }
    
?>