<?php
// Check existence of id parameter before processing further
if(isset($_GET["id_sal"]) && !empty(trim($_GET["id_sal"]))){
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM salario WHERE id_sal = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id_sal"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $empleado = $row["id_emp"];
                $numero = $row["numerocuenta"];
                $banco = $row["banco"];
                $salario = $row["salariobase"];
                $auxilio = $row["auxiliotransporte"];
                $descuentos = $row["descuentosalud"];
                $desceuntop = $row["descuentopension"];
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
    <title>Ver Nomina</title>
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
                        <h1>Ver Empleado Actual</h1>
                    </div>
                    <div class="form-group">
                        <label>Id de Sueldo</label>
                        <p class="form-control-static"><?php echo $row["id_sal"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Id del Empleado</label>
                        <p class="form-control-static"><?php echo $row["id_emp"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Numero de Cuenta Bancaria</label>
                        <p class="form-control-static"><?php echo $row["numerocuenta"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Nombre del Banco</label>
                        <p class="form-control-static"><?php echo $row["banco"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Salario Base</label>
                        <p class="form-control-static"><?php echo $row["salariobase"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Auxilio de Transporte</label>
                        <p class="form-control-static"><?php echo $row["auxiliotransporte"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Descuento de Salud</label>
                        <p class="form-control-static"><?php echo $row["descuentosalud"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Descuento de Pension</label>
                        <p class="form-control-static"><?php echo $row["descuentopension"]; ?></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Volver</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>