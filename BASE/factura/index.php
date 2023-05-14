<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FACTURAS</title>
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
                        <h2 class="pull-left"> Información del Facturas</h2>
                        
                        <a href="create.php" class="btn btn-success pull-right">Agregar Nueva Direccion</a>
                    </div>
                    
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM factura INNER JOIN articulos ON factura.id_art=articulos.id_art INNER JOIN empleados ON factura.id_emp=empleados.id_emp";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){

                            echo "<center>";
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Id de Factura</th>";
                                        echo "<th>Id del Articulo</th>";
                                        echo "<th>Nombre del Articulo</th>";
                                        echo "<th>Tipo de Articulo</th>";
                                        echo "<th>Fecha de Factura</th>";
                                        echo "<th>Id del Usuario que Genero la factura</th>";
                                        echo "<th>Nombre del Usuario</th>";
                                        echo "<th>Nombre2 del Usuario</th>";
                                        echo "<th>Apellido del Usuario</th>";
                                        echo "<th>Apellido2 del Usuario</th>";
                                        echo "<th>Tipo de Usuario</th>";
                                        echo "<th>Cantidad Facturada</th>";
                                        echo "<th>Precio Total</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id_fact'] . "</td>";
                                        echo "<td>" . $row['id_art'] . "</td>";
                                        echo "<td>" . $row['nombre_art'] . "</td>";
                                        echo "<td>" . $row['tipo'] . "</td>";
                                        echo "<td>" . $row['fecha_fact'] . "</td>";
                                        echo "<td>" . $row['id_emp'] . "</td>";
                                        echo "<td>" . $row['nombre1_emp'] . "</td>";
                                        echo "<td>" . $row['nombre2_emp'] . "</td>";
                                        echo "<td>" . $row['apellido1_emp'] . "</td>";
                                        echo "<td>" . $row['apellido2_emp'] . "</td>";
                                        echo "<td>" . $row['tipo_emp']. "</td>";
                                        echo "<td>" . $row['cantidad'] . "</td>";
                                        echo "<td>" . $row['precio_fac'] . "</td>";
                                        echo "<td>";
                                        echo "<a href='update.php?id_fact=". $row['id_fact'] ."' title='Actualizar' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                        echo "<a href='delete.php?id_fact=". $row['id_fact'] ."' title='Borrar' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                    echo "</td>";
                                echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            echo "</center>";
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