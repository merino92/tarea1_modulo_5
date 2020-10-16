<!doctype html>
<html lang="es">
  <head>    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" />
    <title>Editoriales</title>
  </head>
  <body>
    <br/>
    <?php
         include 'conexion.php';
         $genero="";
         $descripcion="";
         $id=0;
         if(isset($_GET["id"])){
            $id=$_GET["id"];
            $conn1=conexion();
            $sql1="SELECT * FROM generos where idGenero=?";
            $re=$conn1->prepare($sql1);
            $re->execute([$_GET["id"]]);
            $da=$re->fetchAll(PDO::FETCH_ASSOC);
            if(count($da)>0){
                foreach($da as $row){
                    $genero=$row["nombreGenero"];
                    $descripcion=$row["descripcion"];
                }
            }else{
                header('Location: /clase1_pdo/generos.php');
            }

         }else{
            header('Location: /clase1_pdo/generos.php');
         }
    ?>


    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Agregar Genero</h4>
            </div>
            <div class="card-body">
                <form action = "" method = "POST">
                    <label>Nombre:</label>
                    <input type = "text" name = "nombre" value="<?php echo($genero);?>" id = "nombre" class="form-control" />
                    <br />
                    <label>Descripcion:</label>
                    <input type = "text" name = "descripcion" value="<?php echo($descripcion);?>" id = "descripcion" class="form-control"/>
                    <br />
                    <input type = "Submit" value ="Actualizar" name = "submit" class="btn btn-warning"/>
                    <a class="btn btn-info" href="generos.php">Regresar</a>
                    <br />
                </form>
            </div>
        </div>
    </div>

    <?php
         if(isset($_POST["submit"])){
           
            $conn =conexion();
            $sql = "UPDATE generos SET nombreGenero=?,descripcion=? WHERE idGenero=?";
            $consulta=$conn->prepare($sql);
            $resultado=$consulta->execute([$_POST["nombre"],$_POST["descripcion"],$id]);
    
            if ($resultado) {
               echo "<div class=\"alert alert-success\" role=\"alert\">";
               echo "Se ha actualizado los datos ";
               echo "</div>";
            } else {
               echo "<div class=\"alert alert-danger\" role=\"alert\">";
               echo "No se pudo actualizar ";
               echo "</div>";               
            }
            
         }
      ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>

