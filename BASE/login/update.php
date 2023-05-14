<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$usuario = $contraseña = $empleado = "";
$usuario_err = $contraseña_err = $empleado_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id_log"]) && !empty($_POST["id_log"])){
    // Get hidden input value
    $id = $_POST["id_log"];
    
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
        // Prepare an update statement
        $sql = "UPDATE login SET user_log=?, password_log= ?, id_emp= ? WHERE id_log=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_usuario, $param_contraseña, $param_empleado,   $param_id);
            
            // Set parameters
            $param_usuario = $usuario;
            $param_contraseña = $contraseña;
            $param_empleado = $empleado;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id_log"]) && !empty(trim($_GET["id_log"]))){
        // Get URL parameter
        $id =  trim($_GET["id_log"]);
        // Prepare a select statement
        $sql = "SELECT * FROM login WHERE id_log= ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $usuario= $row["user_log"];
                    $contraseña= $row["password_log"];
                    $empleado= $row["id_emp"];

                } else{
                    // URL doesn't contain valid id. Redirect to error page
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
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Usuarios de Red</title>
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
                        <h2>Actualizar Registro del Usuario</h2>
                    </div>
                    <p>Edite los valores de entrada y envíe para actualizar el registro.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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
                        <input type="hidden" name="id_log" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>