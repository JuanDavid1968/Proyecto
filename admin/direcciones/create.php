<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$empleado = $direccion = "";
$empleado_err = $direccion_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate emp
    $input_empleado = trim($_POST["empleado"]);
    if(empty($input_empleado)){
        $empleado_err = "Por favor ingrese el Id del empleado.";
    } else{
        $empleado = $input_empleado;
    }
    
    // Validate direccion
    $input_direccion = trim($_POST["direccion"]);
    if(empty($input_direccion)){
        $direccion_err = "Por favor ingrese la Direccion del Empleado.";     
    } else{
        $direccion = $input_direccion;
    }
    
    // Check input errors before inserting in database
    if(empty($empleado_err) && empty($correo_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO direcciones (id_emp, direccion) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_empleado, $param_direccion);
            
            // Set parameters
            $param_empleado = $empleado;
            $param_direccion = $direccion;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agregar Direccion</title>
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
                        <h2>Agregar Direccion Nueva</h2>
                    </div>
                    <p>Favor diligenciar el siguiente formulario, para agregar la direccion.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($empleado_err)) ? 'has-error' : ''; ?>">
                            <label>Id del Empleado</label>
                            <input type="text" name="empleado" class="form-control" value="<?php echo $empleado; ?>">
                            <span class="help-block"><?php echo $empleado_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($direccion_err)) ? 'has-error' : ''; ?>">
                            <label>Direccion del Empleado</label>
                            <input type="text" name="direccion" class="form-control" value="<?php echo $direccion; ?>">
                            <span class="help-block"><?php echo $direccion_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>