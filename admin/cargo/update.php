<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$empleado = $nombre = $funciones = $privilegios = "";
$empleado_err = $nombre_err = $funciones_err = $privilegios_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id_car"]) && !empty($_POST["id_car"])){
    // Get hidden input value
    $id = $_POST["id_car"];
    
    // Validate empleado
    $input_empleado = trim($_POST["empleado"]);
    if(empty($input_empleado)){
        $empleado_err = "Por favor ingrese el Id del Empleado.";
    } else{
        $empleado = $input_empleado;
    }
    // Validate nombre
    $input_nombre = trim($_POST["nombre"]);
    if(empty($input_nombre)){
        $nombre_err = "Por favor ingrese el nombre del cargo.";     
    } else{
        $nombre = $input_nombre;
    }
    // Validate funciones
    $input_funciones = trim($_POST["funciones"]);
    if(empty($input_funciones)){
        $funciones_err = "Por favor ingrese las funciones del cargo.";     
    } else{
        $funciones = $input_funciones;
    }
    // Validate privilegios
    $input_privilegios = trim($_POST["privilegios"]);
    if(empty($input_privilegios)){
        $privilegios_err = "Por favor ingrese el pais donde se encuentra la Bodega.";     
    } else{
        $privilegios = $input_privilegios;
    }
    
    // Check input errors before inserting in database
    if(empty($empleado_err) && empty($nombre_err) && empty($funciones_err) && empty($privilegios_err)){
        // Prepare an update statement
        $sql = "UPDATE cargo SET id_emp=?, nombre_car=?, funciones_car=?, privilegios_car=? WHERE id_car=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_empleado, $param_nombre, $param_funciones,        $param_privilegios ,$param_id);
            
            // Set parameters
            $param_empleado = $empleado;
            $param_nombre = $nombre;
            $param_funciones = $funciones;
            $param_privilegios = $privilegios;
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
    if(isset($_GET["id_car"]) && !empty(trim($_GET["id_car"]))){
        // Get URL parameter
        $id =  trim($_GET["id_car"]);
        // Prepare a select statement
        $sql = "SELECT * FROM cargo WHERE id_car= ?";
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
                    $nombre = $row["nombre_car"];
                    $funciones = $row["funciones_car"];
                    $privilegios = $row["privilegios_car"];
                    
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
    <title>Actualizar Registro de Articulos</title>
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
                        <h2>Actualizar Registro de Articulos</h2>
                    </div>
                    <p>Edite los valores de entrada y envíe para actualizar el registro.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($empleado_err)) ? 'has-error' : ''; ?>">
                            <label>Id del Empleado</label>
                            <input type="text" name="empleado" class="form-control" value="<?php echo $empleado; ?>">
                            <span class="help-block"><?php echo $empleado_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($nombre_err)) ? 'has-error' : ''; ?>">
                            <label>Nombre del Cargo</label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo $nombre; ?>">
                            <span class="help-block"><?php echo $nombre_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($funciones_err)) ? 'has-error' : ''; ?>">
                            <label>Funciones del Cargo</label>
                            <textarea name="funciones" class="form-control"><?php echo $funciones; ?></textarea>
                            <span class="help-block"><?php echo $funciones_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($privilegios_err)) ? 'has-error' : ''; ?>">
                            <label>Privilegios del Cargo</label>
                            <input type="text" name="privilegios" class="form-control" value="<?php echo $privilegios; ?>">
                            <span class="help-block"><?php echo $privilegios_err;?></span>
                        </div>
                        <input type="hidden" name="id_car" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>