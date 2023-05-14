<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inicio de  Nomina</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Nomina</h2>
                        <a href="create.php" class="btn btn-success pull-right">Agregar nueva Nomina</a>
                    </div>
                    <form action="index.php" method="POST">
                        <input type="text" name="buscar">
                        <input type="submit" value="buscar">
                    </form>
                     
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    if(!isset($_POST['buscar'])){

                    $_POST['buscar'] = "";
                    $buscar = $_POST['buscar'];


                    }

                    // Attempt select query execution
                    $buscar = $_POST['buscar'];
                    $sql = "SELECT * FROM salario WHERE id_sal LIKE '%".$buscar."%' OR id_emp LIKE '%".$buscar."%' OR numerocuenta LIKE '%".$buscar."%' OR banco LIKE '%".$buscar."%' OR salariobase LIKE '%".$buscar."%' OR auxiliotransporte LIKE '%".$buscar."%' OR descuentosalud LIKE '%".$buscar."%' OR descuentopension LIKE '%".$buscar."%'";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Id del Sueldo</th>";
                                        echo "<th>Id del Empleado</th>";
                                        echo "<th>Numero de cuenta Bancararia</th>";
                                        echo "<th>Nombre del Banco</th>";
                                        echo "<th>Salario base del empleado</th>";
                                        echo "<th>Auxilio de transporte del empleado</th>";
                                        echo "<th>Descuento de salud del empleado</th>";
                                        echo "<th>Descuento de pensión del empleado</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id_sal'] . "</td>";
                                        echo "<td>" . $row['id_emp'] . "</td>";
                                        echo "<td>" . $row['numerocuenta'] . "</td>";
                                        echo "<td>" . $row['banco'] . "</td>";
                                        echo "<td>" . $row['salariobase'] . "</td>";
                                        echo "<td>" . $row['auxiliotransporte'] . "</td>";
                                        echo "<td>" . $row['descuentosalud'] . "</td>";
                                        echo "<td>" . $row['descuentopension'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='read.php?id_sal=". $row['id_sal'] ."' title='Ver' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='update.php?id_sal=". $row['id_sal'] ."' title='Actualizar' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='delete.php?id_sal=". $row['id_sal'] ."' title='Borrar' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
    <center><a href="../index.html" class="btn btn-success pull-center">Volver a menu principal</a></center>
</body>
</html>