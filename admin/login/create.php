<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$usuario = $contraseña = $empleado = "";
$usuario_err = $contraseña_err = $empleado_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate usuario
    $input_usuario = trim($_POST["usuario"]);
    if(empty($input_usuario)){
        $usuario_err = "Por favor usuario del empleado.";
    } else{
        $usuario = $input_usuario;
    }
    
    // Validate contraseña
    $input_contraseña = trim($_POST["contraseña"]);
    if(empty($input_contraseña)){
        $contraseña_err = "Por favor ingrese la contraseña del Empleado.";     
    } else{
        $contraseña = $input_contraseña;
    }

    // Validate empleado
    $input_empleado = trim($_POST["empleado"]);
    if(empty($input_empleado)){
        $empleado_err = "Por favor ingrese el Id del Empleado.";     
    } else{
        $empleado = $input_empleado;
    }
    
    // Check input errors before inserting in database
    if(empty($usuario_err) && empty($contraseña_err) && empty($empleado_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO login (user_log, password_log, id_emp) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_usuario, $param_contraseña, $param_empleado);
            
            // Set parameters
            $param_usuario = $usuario;
            $param_contraseña = $contraseña;
            $param_empleado = $empleado;
            
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
    <title>Agregar Usuario de Red</title>
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
                        <h2>Agregar Usuario Nuevo</h2>
                    </div>
                    <p>Favor diligenciar el siguiente formulario, para agregar el correo.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($usuario_err)) ? 'has-error' : ''; ?>">
                            <label>Usuario del Empleado</label>
                            <input type="text" name="usuario" class="form-control" value="<?php echo $usuario; ?>">
                            <span class="help-block"><?php echo $usuario_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($contraseña_err)) ? 'has-error' : ''; ?>">
                            <label>Contraseña del Empleado</label>
                            <input type="text" name="contraseña" class="form-control" value="<?php echo $contraseña; ?>">
                            <span class="help-block"><?php echo $contraseña_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($empleado_err)) ? 'has-error' : ''; ?>">
                            <label>Id del Empleado</label>
                            <input type="text" name="empleado" class="form-control" value="<?php echo $empleado; ?>">
                            <span class="help-block"><?php echo $empleado_err;?></span>
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