<?php
    if (isset($_GET['codigo'])) {
        include 'conexion.php';
        $conn = conexion();
           
        // Verificamos la conexión
        $sql = "DELETE FROM autores WHERE codigoAutor = ?";
        $res=$conn->prepare($sql);
        $result=$res->execute([$_GET["codigo"]]);
        if ($result) {
            header('Location: /clase1_pdo/autores.php?result=1');                
            exit();
        } else {
            header('Location: /clase1_pdo/autores.php?result=0');
        }
            
    } else {
        header('Location: /clase1_pdo/autores.php?result=0');
    }



?>