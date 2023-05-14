<?php
// Check existence of id parameter before processing further
if(isset($_GET["id_inginv"]) && !empty(trim($_GET["id_inginv"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM ingreso_inventario WHERE id_inginv = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id_inginv"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $articulo = $row["id_art"];
                $fecha = $row["fechaingreso"];
                $hora = $row["horaingreso"];
                $cantidad = $row["cantidad_inginv"];
                $empleado = $row["id_emp"];
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
    <title>Ver Ingreso de Inventario</title>
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
                        <h1>Ver Ingreso Actual</h1>
                    </div>
                    <div class="form-group">
                        <label>Id del Inventario Ingresado</label>
                        <p class="form-control-static"><?php echo $row["id_inginv"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Id del Articulo</label>
                        <p class="form-control-static"><?php echo $row["id_art"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Fecha de Ingreso</label>
                        <p class="form-control-static"><?php echo $row["fechaingreso"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Hora de Ingreso</label>
                        <p class="form-control-static"><?php echo $row["horaingreso"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Cantidad Ingresada</label>
                        <p class="form-control-static"><?php echo $row["cantidad_inginv"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Id del Empleado que lo ingreso</label>
                        <p class="form-control-static"><?php echo $row["id_emp"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Id de la Bodega donde fue ingresado</label>
                        <p class="form-control-static"><?php echo $row["id_bod"]; ?></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Volver</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>