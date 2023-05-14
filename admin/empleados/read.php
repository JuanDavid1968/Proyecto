<?php
// Check existence of id parameter before processing further
if(isset($_GET["id_emp"]) && !empty(trim($_GET["id_emp"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM empleados WHERE id_emp = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id_emp"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $nombre1 = $row["nombre1_emp"];
                $nombre2 = $row["nombre2_emp"];
                $apellido1 = $row["apellido1_emp"];
                $apellido2 = $row["apellido2_emp"];
                $sexo = $row["sexo_emp"];
                $fechanacim = $row["fechanacim_emp"];
                $tipo = $row["tipo_emp"];
                $cedula = $row["cedula_emp"];
                $bodega = $row["id_bod"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ver Usuarios</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Ver Usuario Actual Actual</h1>
                    </div>
                    <div class="form-group">
                        <label>Id del Usuario</label>
                        <p class="form-control-static"><?php echo $row["id_emp"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Primer Nombre del Usuario</label>
                        <p class="form-control-static"><?php echo $row["nombre1_emp"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Segundo Nombre del Usuario</label>
                        <p class="form-control-static"><?php echo $row["nombre2_emp"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Primer Apellido del Usuario</label>
                        <p class="form-control-static"><?php echo $row["apellido1_emp"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Segundo Apellido del Usuario</label>
                        <p class="form-control-static"><?php echo $row["apellido2_emp"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Sexo del Empleadp</label>
                        <p class="form-control-static"><?php echo $row["sexo_emp"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Fecha Nacimiento del Usuario</label>
                        <p class="form-control-static"><?php echo $row["fechanacim_emp"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Tipo del Usuario</label>
                        <p class="form-control-static"><?php echo $row["tipo_emp"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Cedula del Usuario</label>
                        <p class="form-control-static"><?php echo $row["cedula_emp"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Id de la bodega</label>
                        <p class="form-control-static"><?php echo $row["id_bod"]; ?></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Volver</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>