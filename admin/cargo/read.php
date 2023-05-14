<?php
// Check existence of id parameter before processing further
if(isset($_GET["id_car"]) && !empty(trim($_GET["id_car"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM cargo WHERE id_car = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id_car"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $empleado = $row["id_emp"];
                $nombre = $row["nombre_car"];
                $funciones = $row["funciones_car"];
                $privilegios = $row["privilegios_car"];
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
    <title>Ver Cargos</title>
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
                        <h1>Ver Cargos</h1>
                    </div>
                    <div class="form-group">
                        <label>Id del Cargo</label>
                        <p class="form-control-static"><?php echo $row["id_car"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Id del Empleado</label>
                        <p class="form-control-static"><?php echo $row["id_emp"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Nombre del Cargo</label>
                        <p class="form-control-static"><?php echo $row["nombre_car"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Funciones del Cargo</label>
                        <p class="form-control-static"><?php echo $row["funciones_car"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Privilegios del Cargo</label>
                        <p class="form-control-static"><?php echo $row["privilegios_car"]; ?></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Volver</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>