<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NOMINA</title>
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
                        <h2 class="pull-left">NOMINA DEL EMPLEADO</h2>
                        
                        
                    </div>

                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM empleados INNER JOIN salario ON empleados.id_emp=salario.id_emp";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Id del Empleado</th>";
                                        echo "<th>Primer Nombre</th>";
                                        echo "<th>Segundo Nombre</th>";
                                        echo "<th>Primer Apellido</th>";
                                        echo "<th>Segundo Apellido</th>";
                                        echo "<th>Sexo del Empleado</th>";
                                        echo "<th>Fecha de Nacimiento</th>";
                                        echo "<th>Ciudad de Nacimiento</th>";
                                        echo "<th>Cedula del Empleado</th>";
                                        echo "<th>Numero de cuenta Bancaria</th>";
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
                                        echo "<td>" . $row['id_emp'] . "</td>";
                                        echo "<td>" . $row['nombre1_emp'] . "</td>";
                                        echo "<td>" . $row['nombre2_emp'] . "</td>";
                                        echo "<td>" . $row['apellido1_emp'] . "</td>";
                                        echo "<td>" . $row['apellido2_emp'] . "</td>";
                                        echo "<td>" . $row['sexo_emp'] . "</td>";
                                        echo "<td>" . $row['fechanacim_emp'] . "</td>";
                                        echo "<td>" . $row['ciudadnacim_emp'] . "</td>";
                                        echo "<td>" . $row['cedula_emp'] . "</td>";
                                        echo "<td>" . $row['numerocuenta'] . "</td>";
                                        echo "<td>" . $row['banco'] . "</td>";
                                        echo "<td>" . $row['salariobase'] . "</td>";
                                        echo "<td>" . $row['auxiliotransporte'] . "</td>";
                                        echo "<td>" . $row['descuentosalud'] . "</td>";
                                        echo "<td>" . $row['descuentopension'] . "</td>";
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