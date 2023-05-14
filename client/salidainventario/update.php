<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$articulo = $fecha = $hora = $razon = $cantidad = $empleado = $bodega = "";

$articulo_err = $fecha_err = $hora_err = $razon_err = $cantidad_err = $empleado_err = $bodega_err = "";

 
// Processing form data when form is submitted
if(isset($_POST["id_salinv"]) && !empty($_POST["id_salinv"])){
    // Get hidden input value
    $id = $_POST["id_salinv"];
    
    // Validate articulo
    $input_articulo = trim($_POST["articulo"]);
    if(empty($input_articulo)){
        $articulo_err = "Por favor ingrese el Id del articulo";
    } else{
        $articulo = $input_articulo;
    }

    // Validate fecha
    $input_fecha = trim($_POST["fecha"]);
    if(empty($input_fecha)){
        $fecha_err = "Por favor ingrese la fecha de salida del articulo";
    } else{
        $fecha = $input_fecha;
    }

    // Validate hora
    $input_hora = trim($_POST["hora"]);
    if(empty($input_hora)){
        $hora_err = "Por favor ingrese la hora de salida del articulo";
    } else{
        $hora = $input_hora;
    }

    // Validate razon
    $input_razon = trim($_POST["razon"]);
    if(empty($input_razon)){
        $razon_err = "Por favor ingrese la razon de salida del articulo";
    } else{
        $razon = $input_razon;
    }

    // Validate cantidad
    $input_cantidad = trim($_POST["cantidad"]);
    if(empty($input_cantidad)){
        $cantidad_err = "Por favor ingrese el monto de la cantidad de salida el articulo";
    } else{
        $cantidad = $input_cantidad;
    }

    // Validate empleado
    $input_empleado = trim($_POST["empleado"]);
    if(empty($input_empleado)){
        $empleado_err = "Por favor ingrese el Id del Empleado";
    } else{
        $empleado = $input_empleado;
    }

    // Validate bodega
    $input_bodega = trim($_POST["bodega"]);
    if(empty($input_bodega)){
        $bodega_err = "Por favor ingrese el Id de la Bodega";
    } else{
        $bodega = $input_bodega;
    }


    // Check input errors before inserting in database
    if(empty($articulo_err) && empty($fecha_err) && empty($hora_err)  && empty($razon_err) && empty($cantidad_err) &&  empty($empleado_err) && empty($bodega_err)){
        // Prepare an update statement
        $sql = "UPDATE salida_inventario SET id_art = ?, fechasalida = ?, horasalida = ?, razonsalida = ?,  cantidad_salinv = ?, id_emp = ?, id_bod = ? WHERE id_salinv=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssss",  $param_articulo, $param_fecha, $param_hora, $param_razon, $param_cantidad, $param_empleado, $param_bodega, $param_id);
            
            // Set parameters
            $param_articulo = $articulo;
            $param_fecha = $fecha;
            $param_hora = $hora;
            $param_razon = $razon;
            $param_cantidad = $cantidad;
            $param_empleado = $empleado;
            $param_bodega = $bodega;
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
    }   mysqli_stmt_close($stmt);

    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id_salinv"]) && !empty(trim($_GET["id_salinv"]))){
        // Get URL parameter
        $id =  trim($_GET["id_salinv"]);
        // Prepare a select statement
        $sql = "SELECT * FROM salida_inventario WHERE id_salinv= ?";
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
                    
                    $articulo = $row["id_art"];
                    $fecha = $row["fechasalida"];
                    $hora = $row["horasalida"];
                    $razon = $row["razonsalida"];
                    $cantidad = $row["cantidad_salinv"];
                    $empleado = $row["id_emp"];
                    $bodega = $row["id_bod"];


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
    <title>Actualizar Registro de Salida Inventario</title>
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
                        <h2>Actualizar Registro de Salida de Inventario</h2>
                    </div>
                    <p>Edite los valores de entrada y envíe para actualizar el registro.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($articulo_err)) ? 'has-error' : ''; ?>">
                            <label>Id del Articulo</label>
                            <input type="text" name="articulo" class="form-control" value="<?php echo $articulo; ?>">
                            <span class="help-block"><?php echo $articulo_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($fecha_err)) ? 'has-error' : ''; ?>">
                            <label>Fecha de Salida del Articulo (AAAA-MM-DD)</label>
                            <input type="text" name="fecha" class="form-control" value="<?php echo $fecha; ?>">
                            <span class="help-block"><?php echo $fecha_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($hora_err)) ? 'has-error' : ''; ?>">
                            <label>Hora de Salida del Articulo</label>
                            <input type="text" name="hora" class="form-control" value="<?php echo $hora; ?>">
                            <span class="help-block"><?php echo $hora_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($razon_err)) ? 'has-error' : ''; ?>">
                            <label>Razon de Salida del Articulo</label>
                            <input type="text" name="razon" class="form-control" value="<?php echo $razon; ?>">
                            <span class="help-block"><?php echo $razon_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($cantidad_err)) ? 'has-error' : ''; ?>">
                            <label>Cantidad Sacada</label>
                            <input type="text" name="cantidad" class="form-control" value="<?php echo $cantidad; ?>">
                            <span class="help-block"><?php echo $cantidad_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($empleado_err)) ? 'has-error' : ''; ?>">
                            <label>Id del Empleado que lo saco</label>
                            <input type="text" name="empleado" class="form-control" value="<?php echo $empleado; ?>">
                            <span class="help-block"><?php echo $empleado_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($bodega_err)) ? 'has-error' : ''; ?>">
                            <label>Id de la Bodeda donde se salio</label>
                            <input type="text" name="bodega" class="form-control" value="<?php echo $bodega; ?>">
                            <span class="help-block"><?php echo $bodega_err;?></span>
                        </div>
                        <input type="hidden" name="id_salinv" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>