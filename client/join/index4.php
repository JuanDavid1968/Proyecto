<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ENTRADA DE INVENTARIO</title>
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
                        <h2 class="pull-left"> Información del ENTRADA</h2>
                        
                        
                    </div>

                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM ingreso_inventario INNER JOIN empleados ON empleados.id_emp=ingreso_inventario.id_emp INNER JOIN articulos ON articulos.id_art=ingreso_inventario.id_art INNER JOIN cargo ON cargo.id_emp=ingreso_inventario.id_emp INNER JOIN bodega ON bodega.id_bod=ingreso_inventario.id_bod";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Id del Ingreso</th>";
                                        echo "<th>Id del Articulo</th>";
                                        echo "<th>Nombre del Articulo</th>";
                                        echo "<th>Tipo de Articulo</th>";
                                        echo "<th>Descripcion del Articulo</th>";
                                        echo "<th>Precio del Articulo</th>";
                                        echo "<th>Fecha de Ingreso</th>";
                                        echo "<th>Hora de Ingreso</th>";
                                        echo "<th>Cantidad Ingresada</th>";
                                        echo "<th>Id del empleado que lo ingreso</th>";
                                        echo "<th>Primer Nombre</th>";
                                        echo "<th>Segundo Nombre</th>";
                                        echo "<th>Primer Apellido</th>";
                                        echo "<th>Segundo Apellido</th>";
                                        echo "<th>Cedula del Empleado</th>";
                                        echo "<th>Cargo del Empleado";
                                        echo "<th>Id de la Bodega donde Ingreso</th>";
                                        echo "<th>Direccion de la Bodega</th>";
                                        echo "<th>Barrio de la Bodega</th>";
                                        echo "<th>Ciudad de la Bodega</th>";
                                        echo "<th>Pais de la Bodega</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id_inginv'] . "</td>";
                                        echo "<td>" . $row['id_art'] . "</td>";
                                        echo "<td>" . $row['nombre_art'] . "</td>";
                                        echo "<td>" . $row['tipo'] . "</td>";
                                        echo "<td>" . $row['descripcion_art'] . "</td>";
                                        echo "<td>" . $row['precio_art'] . "</td>";
                                        echo "<td>" . $row['fechaingreso'] . "</td>";
                                        echo "<td>" . $row['horaingreso'] . "</td>";
                                        echo "<td>" . $row['cantidad_inginv'] . "</td>";
                                        echo "<td>" . $row['id_emp'] . "</td>";
                                        echo "<td>" . $row['nombre1_emp'] . "</td>";
                                        echo "<td>" . $row['nombre2_emp'] . "</td>";
                                        echo "<td>" . $row['apellido1_emp'] . "</td>";
                                        echo "<td>" . $row['apellido2_emp'] . "</td>";
                                        echo "<td>" . $row['cedula_emp'] . "</td>";
                                        echo "<td>" . $row['nombre_car'] . "</td>";
                                        echo "<td>" . $row['id_bod'] . "</td>";
                                        echo "<td>" . $row['direccion_bod'] . "</td>";
                                        echo "<td>" . $row['barrio_bod'] . "</td>";
                                        echo "<td>" . $row['ciudad_bod'] . "</td>";
                                        echo "<td>" . $row['pais_bod'] . "</td>";
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