<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$empleado = $telefono = "";
$empleado_err = $telefono_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id_tel"]) && !empty($_POST["id_tel"])){
    // Get hidden input value
    $id = $_POST["id_tel"];
    
    //Validate emp
    $input_empleado = trim($_POST["empleado"]);
    if(empty($input_empleado)){
        $empleado_err = "Por favor ingrese el Id del empleado.";
    } else{
        $empleado = $input_empleado;
    }
    
    // Validate telefono
    $input_telefono = trim($_POST["telefono"]);
    if(empty($input_telefono)){
        $ctelefono_err = "Por favor ingrese el telefono del Empleado.";     
    } else{
        $telefono = $input_telefono;
    }
    
    // Check input errors before inserting in database
    if(empty($empleado_err) && empty($telefono_err)){
        // Prepare an update statement
        $sql = "UPDATE telefonos SET id_emp=?, telefono = ? WHERE id_tel=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_empleado, $param_telefono ,$param_id);
            
            // Set parameters
            $param_empleado = $empleado;
            $param_telefono = $telefono;
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
    if(isset($_GET["id_tel"]) && !empty(trim($_GET["id_tel"]))){
        // Get URL parameter
        $id =  trim($_GET["id_tel"]);
        // Prepare a select statement
        $sql = "SELECT * FROM telefonos WHERE id_tel= ?";
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
                    $empleado = $row["id_emp"];
                    $telefono = $row["telefono"];

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
    <title>Actualizar Telefono</title>
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
                        <h2>Actualizar Registro de Telefonos</h2>
                    </div>
                    <p>Edite los valores de entrada y envíe para actualizar el registro.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($empleado_err)) ? 'has-error' : ''; ?>">
                            <label>Id del Empleado</label>
                            <input type="text" name="empleado" class="form-control" value="<?php echo $empleado; ?>">
                            <span class="help-block"><?php echo $empleado_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($telefono_err)) ? 'has-error' : ''; ?>">
                            <label>Telefono del Empleado</label>
                            <input type="text" name="telefono" class="form-control" value="<?php echo $telefono; ?>">
                            <span class="help-block"><?php echo $telefono_err;?></span>
                        </div>
                        </div>
                        <input type="hidden" name="id_tel" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>