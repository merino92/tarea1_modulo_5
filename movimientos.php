<!doctype html>
<html lang="es">
  <head>    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" />
    <title>Movimientos</title>
  </head>
  <body>
    <br/>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-10">
                        <h4>Movimientos de Libros</h4>
                    </div>
                    
                </div>                
            </div>
            <?php include 'conexion.php'; ?>
            <div class="card-body">
                <form action="" method="post">
                    <label for="">Tipo</label>
                    <select name="tipo" id="" class="form-control">
                        <option value="1">ENTRADA</option>
                        <option value="2">SALIDA</option>
                    </select>
                    </br>
                    <label for="">fecha</label>
                    <input type="date" name="fecha" value="<?php echo(date('Y-m-d'));?>" id="" class="form-control">
                    </br>
                    <label for="">Libro</label>
                    <select name="libro" class="form-control" id="">
                        <?php
                            $conn = conexion();
                            $sql = "SELECT * FROM libros";
                            $res=$conn->query($sql);
                            $result=$res->fetchAll(PDO::FETCH_ASSOC);
                            if (count($result) > 0) { 
                                foreach($result as $row) {
                                    echo "<option value=\"".$row["codigoLibro"]."\">".$row["nombreLibro"]."</option>";
                                } 
                             } 
                        ?>
                    </select>
                    </br>
                    <label for="">Cantidad</label>
                    <input type="number" name="cantidad" class="form-control" id="">
                    </br>
                    <input type = "Submit" value ="Guardar" name = "submit" class="btn btn-success"/>
                    <a class="btn btn-info" href="libros.php">Regresar</a>
                    <br />

                </form>
            
            </div>

        </div>

        <?php

            if(isset($_POST["submit"])){

                $co=conexion();
                $exitencias=0;
                $sql="SELECT * FROM libros where codigoLibro=?";
                $res=$co->prepare($sql);
                $res->execute([$_POST["libro"]]);
                $result=$res->fetchAll(PDO::FETCH_ASSOC);
                if(count($result)>0){
                    foreach($result as $row){
                         $exitencias=$row["existencias"];   
                    }
                }

                if($_POST["tipo"]==1){
                    $exitencias=$exitencias+$_POST["cantidad"];
                    $tran=conexion();
                    try{
                       $tran->beginTransaction();
                       $sql="INSERT INTO movimientos(fecha,codigoLibro,entrada,salida,saldo) VALUES(?,?,?,?,?)";
                       $res=$tran->prepare($sql);
                       $res->execute([$_POST['fecha'],$_POST['libro'],$_POST["cantidad"],0,$exitencias]);
                       $sql="UPDATE libros SET existencias=? where codigoLibro=?";
                       $res=$tran->prepare($sql);
                       $res->execute([$exitencias,$_POST['libro']]);  
                       $tran->commit();   
                       echo "<div class=\"alert alert-success\" role=\"alert\">";
                       echo "movimiento realizado";
                       echo "</div>";
                    }catch(Exception $e){
                        $tran->rollBack();
                      echo "<div class=\"alert alert-danger\" role=\"alert\">";
                      echo $e->getMessage();
                      echo "</div>"; 
                    }      
                }else{
                    $exitencias=$exitencias-$_POST["cantidad"];
                    if($exitencias<0){
                        echo "<div class=\"alert alert-danger\" role=\"alert\">";
                        echo "No hay suficientes existencias ";
                        echo "</div>"; 
                    }{
                        $tran=conexion();
                      try{
                         $tran->beginTransaction();
                         $sql="INSERT INTO movimientos(fecha,codigoLibro,entrada,salida,saldo) VALUES(?,?,?,?,?)";
                         $res=$tran->prepare($sql);
                         $res->execute([$_POST['fecha'],$_POST['libro'],0,$_POST["cantidad"],$exitencias]);
                         $sql="UPDATE libros SET existencias=? where codigoLibro=?";
                         $res=$tran->prepare($sql);
                         $res->execute([$exitencias,$_POST['libro']]);  
                         $tran->commit();   
                         echo "<div class=\"alert alert-success\" role=\"alert\">";
                         echo "movimiento realizado";
                         echo "</div>";
                      }catch(Exception $e){
                          $tran->rollBack();
                        echo "<div class=\"alert alert-danger\" role=\"alert\">";
                        echo $e->getMessage();
                        echo "</div>"; 
                      }      
                    }
                }
                

            }                
        ?>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  </body>
</html>

