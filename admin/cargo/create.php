<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$empleado = $nombre = $funciones = $privilegios = "";
$empleado_err = $nombre_err = $funciones_err = $privilegios_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate empleado
    $input_empleado = trim($_POST["empleado"]);
    if(empty($input_empleado)){
        $empleado_err = "Por favor ingrese el id del empleado.";
    } else{
        $empleado = $input_empleado;
    }
    
    // Validate nombre
    $input_nombre = trim($_POST["nombre"]);
    if(empty($input_nombre)){
        $nombre_err = "Por favor ingrese el Nombre del cargo.";     
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
        $privilegios_err = "Por favor ingrese el los privilegios del cargo.";     
    } else{
        $privilegios = $input_privilegios;
    }
    
    // Check input errors before inserting in database
    if(empty($empleado_err) && empty($nombre_err) && empty($funciones_err) && empty($privilegios_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO cargo (id_emp, nombre_car, funciones_car, privilegios_car) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_empleado, $param_nombre, $param_funciones, $param_privilegios);
            
            // Set parameters
            $param_empleado = $empleado;
            $param_nombre = $nombre;
            $param_funciones = $funciones;
            $param_privilegios = $privilegios;
            
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
    <title>Agregar Cargos</title>
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
                        <h2>Agregar Cargo Nuevo del Empleado</h2>
                    </div>
                    <p>Favor diligenciar el siguiente formulario, para agregar el Cargo.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>