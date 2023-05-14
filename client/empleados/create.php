<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$nombreone = $nombretwo = $apellidoone = $apellidotwo = $sexo = $fechanacim = $tipo = $cedula =$bodega = "";

$nombreone_err = $nombretwo_err = $apellidoone_err = $apellidotwo_err = $sexo_err= $fechanacim_err = $tipo_err = $cedula_err =$bodega_err = "";

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate nombreone
    $input_nombreone = trim($_POST["nombre1"]);
    if(empty($input_nombreone)){
        $nombreone_err = "Por favor ingrese el primer nombre.";
    } else{
        $nombreone = $input_nombreone;
    }
    
    // Validate nombretwo
    $input_nombretwo = trim($_POST["nombre2"]);
    if(empty($input_nombretwo)){
        $nombretwo_err = "Por favor ingrese el segundo nombre.";
    } else{
        $nombretwo = $input_nombretwo;
    }
    
    // Validate apellidoone
    $input_apellidoone = trim($_POST["apellido1"]);
    if(empty($input_apellidoone)){
        $apellidoone_err = "Por favor ingrese el primer apellido.";
    } else{
        $apellidoone = $input_apellidoone;
    }

    // Validate apellidotwo
    $input_apellidotwo = trim($_POST["apellido2"]);
    if(empty($input_apellidotwo)){
        $apellidotwo_err = "Por favor ingrese el segundo apellido.";
    } else{
        $apellidotwo = $input_apellidotwo;
    }

    // Validate sexo
    $input_sexo = trim($_POST["sexo"]);
    if(empty($input_sexo)){
        $sexo_err = "Por favor ingrese el sexo del usuario.";
    } else{
        $sexo = $input_sexo;
    }

    // Validate fechanacim
    $input_fechanacim = trim($_POST["fecha"]);
    if(empty($input_fechanacim)){
        $fechanacim_err = "Por favor ingrese la fecha de nacimiento del usuario.";
    } else{
        $fechanacim = $input_fechanacim;
    }

    // Validate tipo
    $input_tipo = trim($_POST["tipo"]);
    if(empty($input_tipo)){
        $tipo_err = "Por favor ingrese tipo de usuario.";
    } else{
        $tipo = $input_tipo;
    }

    // Validate cedula
    $input_cedula = trim($_POST["cedula"]);
    if(empty($input_cedula)){
        $cedula_err = "Por favor ingrese la cedula del usuario.";
    } else{
        $cedula = $input_cedula;
    }

    // Validate bodega
    $input_bodega = trim($_POST["bodega"]);
    if(empty($input_bodega)){
        $bodega_err = "Por favor ingrese el id de la bodega del usuario.";
    } else{
        $bodega = $input_bodega;
    }


    // Check input errors before inserting in database
    if(empty($nombreone_err) && empty($nombretwo_err) && empty($apellidoone_err) && empty($apellidotwo_err) &&  empty($sexo_err) && empty($fechanacim_err) && empty($tipo_err) && empty($cedula_err) && empty($bodega_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO empleados (nombre1_emp, nombre2_emp, apellido1_emp, apellido2_emp, sexo_emp, fechanacim_emp, tipo_emp, cedula_emp, id_bod) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssssss", $param_nombreone, $param_nombretwo, $param_apellidoone,  $param_apellidotwo, $param_sexo, $param_fechanacim, $param_tipo, $param_cedula, $param_bodega);
            
            // Set parameters
            $param_nombreone = $nombreone;
            $param_nombretwo = $nombretwo;
            $param_apellidoone = $apellidoone;
            $param_apellidotwo = $apellidotwo;
            $param_sexo = $sexo;
            $param_fechanacim = $fechanacim;
            $param_tipo = $tipo;
            $param_cedula = $cedula;
            $param_bodega = $bodega;
            
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
    <title>Agregar Nuevo Empleado</title>
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
                        <h2>Agregar Empleado</h2>
                    </div>
                    <p>Favor diligenciar el siguiente formulario, para agregar un nuevo empleado.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($nombreone_err)) ? 'has-error' : ''; ?>">
                            <label>Primer Nombre del Usuario</label>
                            <input type="text" name="nombre1" class="form-control" value="<?php echo $nombreone; ?>">
                            <span class="help-block"><?php echo $nombreone_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($nombretwo_err)) ? 'has-error' : ''; ?>">
                            <label>Segundo Nombre del Usuario</label>
                            <input type="text" name="nombre2" class="form-control" value="<?php echo $nombretwo; ?>">
                            <span class="help-block"><?php echo $nombretwo_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($apellidoone_err)) ? 'has-error' : ''; ?>">
                            <label>Primer Apellido del Usuario</label>
                            <input type="text" name="apellido1" class="form-control" value="<?php echo $apellidoone; ?>">
                            <span class="help-block"><?php echo $apellidoone_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($apellidotwo_err)) ? 'has-error' : ''; ?>">
                            <label>Segundo Apellido del Usuario</label>
                            <input type="text" name="apellido2" class="form-control" value="<?php echo $apellidotwo; ?>">
                            <span class="help-block"><?php echo $apellidotwo_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($sexo_err)) ? 'has-error' : ''; ?>">
                            <label>Sexo del Usuario</label>
                            <input type="text" name="sexo" class="form-control" value="<?php echo $sexo; ?>">
                            <span class="help-block"><?php echo $sexo_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($fechanacim_err)) ? 'has-error' : ''; ?>">
                            <label>Fecha de nacimiento del Usuario formato AAAA-MM-DD</label>
                            <input type="text" name="fecha" class="form-control" value="<?php echo $fechanacim; ?>">
                            <span class="help-block"><?php echo $fechanacim_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($tipo_err)) ? 'has-error' : ''; ?>">
                            <label>Tipo de Usuario (Empleado/Cliente)</label>
                            <input type="text" name="tipo" class="form-control" value="<?php echo $tipo; ?>">
                            <span class="help-block"><?php echo $tipo_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($cedula_err)) ? 'has-error' : ''; ?>">
                            <label>Cedula del Usuario</label>
                            <input type="text" name="cedula" class="form-control" value="<?php echo $cedula; ?>">
                            <span class="help-block"><?php echo $cedula_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($bodega_err)) ? 'has-error' : ''; ?>">
                            <label>Id de la Bodega del Usuario</label>
                            <input type="text" name="bodega" class="form-control" value="<?php echo $bodega; ?>">
                            <span class="help-block"><?php echo $bodega_err;?></span>
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
