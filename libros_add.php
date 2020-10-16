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
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Agregar libro</h4>
            </div>
            <div class="card-body">
            <?php
                 include 'conexion.php';
            
            ?>
                <form action = "" method = "POST">
                    <label>Codigo:</label>
                    <input type = "text" name = "codigo" id = "codigo" class="form-control"/>
                    <label>Nombre:</label>
                    <input type = "text" name = "nombreLibro" id = "nombreLibro" class="form-control"/>
                    <br />
                    <label>Existencias:</label>
                    <input type = "number" name = "existencias" id = "existencias" class="form-control"/>
                    <br />
                    <label>Precio $:</label>
                    <input type = "number" name = "precio" id = "precio" class="form-control"/>
                    <br />
                    <label>Autor:</label>
                    <select name="autor" id="autor" class="form-control">
                        <?php
                            $conn = conexion();
                            $sql = "SELECT * FROM autores";
                            $res=$conn->query($sql);
                            $result=$res->fetchAll(PDO::FETCH_ASSOC);
                            if (count($result) > 0) {  
                                foreach($result as $row) {
                                 echo "<option value=\"".$row["codigoAutor"]."\">".$row["nombreAutor"]."</option>";
                                }
                             } 
                             
                        
                        ?>

                    </select>
                    <br />
                    <label>Editorial:</label>
                    <select name="editorial" id="editorial" class="form-control">
                        <?php
                            
                             $sql = "SELECT * FROM editoriales";
                             $res=$conn->query($sql);
                             $result=$res->fetchAll(PDO::FETCH_ASSOC);
                             if (count($result) > 0) {      
                                foreach($result as $row) {
                                 echo "<option value=\"".$row["codigoEditorial"]."\">".$row["nombreEditorial"]."</option>";
                                }
                             } 
                        ?>

                    </select>
                    <br />
                    <label>Genero:</label>
                    <select name="genero" id="genero" class="form-control">
                        <?php
                            
                             $conn = conexion();
                             $sql = "SELECT * FROM generos";
                             $res=$conn->query($sql);
                             $result=$res->fetchAll(PDO::FETCH_ASSOC);
                 
                             if (count($result) > 0) {       
                                foreach($result as $row) {
                                 echo "<option value=\"".$row["idGenero"]."\">".$row["nombreGenero"]."</option>";
                                }
                             } 
                            
                        
                        ?>

                    </select>
                    <br />
                    <label for="">Descripcion</label>
                    <textarea name="descripcion" class="form-control" id="" cols="30" rows="10"></textarea>
                    <br/>
                    <input type = "Submit" value ="Guardar" name = "submit" class="btn btn-success"/>
                    <a class="btn btn-info" href="libros.php">Regresar</a>
                    <br />
                </form>
            </div>
        </div>
    </div>

    <?php
         if(isset($_POST["submit"])){
            $conn =conexion();
            try{
                
                $conn->beginTransaction();
                $sql = "INSERT INTO libros(codigoLibro,nombreLibro,existencias,precio,codigoAutor,codigoEditorial,idGenero,descripcion) 
                    VALUES (?,?,?,?,?,?,?,?)";
                $consulta=$conn->prepare($sql);
                $resultado=$consulta->execute([$_POST["codigo"],$_POST["nombreLibro"],$_POST["existencias"],$_POST["precio"],
                                            $_POST["autor"],$_POST["editorial"],$_POST["genero"],$_POST["descripcion"]]);
                $sql="INSERT INTO movimientos(fecha,codigoLibro,entrada,salida,saldo) values(?,?,?,?,?)"; 
                $consulta=$conn->prepare($sql);  
                $resultado=$consulta->execute([date('Y-m-d'),$_POST["codigo"],$_POST["existencias"],0,$_POST["existencias"]]);
                             
            if ($resultado) {
               echo "<div class=\"alert alert-success\" role=\"alert\">";
               echo "Se ha guardado el libro";
               echo "</div>";
               echo date('YYYY-mm-dd');
               $conn->commit();
            } else {
               echo "<div class=\"alert alert-danger\" role=\"alert\">";
               echo "No se pudo guardar el libro. ";
               echo "</div>"; 
                        
            }
            
            }catch(Exception $e){
                $conn->rollBack();
                echo "<div class=\"alert alert-danger\" role=\"alert\">";
               echo "No se pudo guardar el libro. ";
               echo $e->getMessage();
               echo "</div>";   
            }
            
            
         }
      ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>

