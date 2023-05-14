<?php
// Check existence of id parameter before processing further
if(isset($_GET["id_bod"]) && !empty(trim($_GET["id_bod"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM bodega WHERE id_bod = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id_bod"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $direccion= $row["direccion_bod"];
                $barrio = $row["barrio_bod"];
                $ciudad = $row["ciudad_bod"];
                $pais = $row["pais_bod"];
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
    <title>Ver Bodega</title>
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
                        <h1>Ver Bodega Actual</h1>
                    </div>
                    <div class="form-group">
                        <label>Id de la Bodega</label>
                        <p class="form-control-static"><?php echo $row["id_bod"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Direccion de la Bodega</label>
                        <p class="form-control-static"><?php echo $row["direccion_bod"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Barrio de la Bodega</label>
                        <p class="form-control-static"><?php echo $row["barrio_bod"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Ciudad de la Bodega</label>
                        <p class="form-control-static"><?php echo $row["ciudad_bod"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Pais de la Bodega</label>
                        <p class="form-control-static"><?php echo $row["pais_bod"]; ?></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Volver</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>