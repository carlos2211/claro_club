<?php
    /*$servername = "localhost";
    $username = "usr_claro";
    $password = "havas";
    $dbname = "claro_club";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }*/
    define('DB_SERVER', 'localhost');
    define('DB_SERVER_USERNAME', 'mediacon_cluser');
    define('DB_SERVER_PASSWORD', 'e68c58fed5');
    define('DB_DATABASE', 'claro_club');

    $con = mysql_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD);
    mysql_select_db(DB_DATABASE, $con);
?>