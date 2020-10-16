<?php
    

    function conexion(){
        $dsn = "mysql:host=localhost;dbname=libros";
        $user = "root";
        $passwd = "";
        $conn=new PDO($dsn,$user,$passwd);
        return $conn;
    }




?>