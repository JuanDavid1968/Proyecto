<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EMPLEADOS</title>
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
                        <h2 class="pull-left"> Información del Empleados que laboran en la Empresa</h2>
                        
                        
                    </div>

                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM empleados INNER JOIN bodega ON empleados.id_bod=bodega.id_bod INNER JOIN direcciones ON empleados.id_emp=direcciones.id_emp INNER JOIN telefonos ON empleados.id_emp=telefonos.id_emp INNER JOIN correos ON empleados.id_emp=correos.id_emp INNER JOIN cargo ON empleados.id_emp=cargo.id_emp WHERE sexo_emp = 'MASCULINO';";
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
                                        echo "<th>Id de la Bodega</th>";
                                        echo "<th>Direccion de la Bodega</th>";
                                        echo "<th>Barrio de la Bodega</th>";
                                        echo "<th>Ciudad de la Bodega</th>";
                                        echo "<th>Pais de la Bodega</th>";
                                        echo "<th>Nombre del Cargo</th>";
                                        echo "<th>Funciones del Cargo</th>";
                                        echo "<th>Privilegios del Cargo</th>";
                                        echo "<th>Direccion del Empleado</th>";
                                        echo "<th>Telefono del Empleado</th>";
                                        echo "<th>Correo del Empleado</th>";  
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
                                        echo "<td>" . $row['id_bod'] . "</td>";
                                        echo "<td>" . $row['direccion_bod'] . "</td>";
                                        echo "<td>" . $row['barrio_bod'] . "</td>";
                                        echo "<td>" . $row['ciudad_bod'] . "</td>";
                                        echo "<td>" . $row['pais_bod'] . "</td>";
                                        echo "<td>" . $row['nombre_car'] . "</td>";
                                        echo "<td>" . $row['funciones_car'] . "</td>";
                                        echo "<td>" . $row['privilegios_car'] . "</td>";
                                        echo "<td>" . $row['direccion'] . "</td>";
                                        echo "<td>" . $row['telefono'] . "</td>";
                                        echo "<td>" . $row['correo'] . "</td>";
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