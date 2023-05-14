<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$articulo = $fecha = $hora = $cantidad = $empleado = $bodega = "";

$articulo_err = $fecha_err = $hora_err = $cantidad_err = $empleado_err = $bodega_err = "";

 
// Processing form data when form is submitted
if(isset($_POST["id_inginv"]) && !empty($_POST["id_inginv"])){
    // Get hidden input value
    $id = $_POST["id_inginv"];
    
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
        $fecha_err = "Por favor ingrese la fecha de Ingreso del articulo";
    } else{
        $fecha = $input_fecha;
    }

    // Validate hora
    $input_hora = trim($_POST["hora"]);
    if(empty($input_hora)){
        $hora_err = "Por favor ingrese la hora de Ingreso del articulo";
    } else{
        $hora = $input_hora;
    }

    // Validate cantidad
    $input_cantidad = trim($_POST["cantidad"]);
    if(empty($input_cantidad)){
        $cantidad_err = "Por favor ingrese el monto de la cantidad ingresada el articulo";
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
    if(empty($articulo_err) && empty($fecha_err) && empty($hora_err) && empty($cantidad_err) &&  empty($empleado_err) && empty($bodega_err)){
        // Prepare an update statement
        $sql = "UPDATE ingreso_inventario SET id_art = ?, fechaingreso = ?, horaingreso = ?, cantidad_inginv = ?, id_emp = ?, id_bod = ? WHERE id_inginv=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss",  $param_articulo, $param_fecha, $param_hora, $param_cantidad, $param_empleado, $param_bodega, $param_id);
            
            // Set parameters
            $param_articulo = $articulo;
            $param_fecha = $fecha;
            $param_hora = $hora;
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
    }        mysqli_stmt_close($stmt);

    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id_inginv"]) && !empty(trim($_GET["id_inginv"]))){
        // Get URL parameter
        $id =  trim($_GET["id_inginv"]);
        // Prepare a select statement
        $sql = "SELECT * FROM ingreso_inventario WHERE id_inginv= ?";
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
                    $fecha = $row["fechaingreso"];
                    $hora = $row["horaingreso"];
                    $cantidad = $row["cantidad_inginv"];
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
    <title>Actualizar Registro Inventario Ingresado</title>
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
                        <h2>Actualizar Registro de Ingreso de Inventario</h2>
                    </div>
                    <p>Edite los valores de entrada y envíe para actualizar el registro.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($articulo_err)) ? 'has-error' : ''; ?>">
                            <label>Id del Articulo</label>
                            <input type="text" name="articulo" class="form-control" value="<?php echo $articulo; ?>">
                            <span class="help-block"><?php echo $articulo_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($fecha_err)) ? 'has-error' : ''; ?>">
                            <label>Fecha de Ingreso del Articulo (AAAA-MM-DD)</label>
                            <input type="text" name="fecha" class="form-control" value="<?php echo $fecha; ?>">
                            <span class="help-block"><?php echo $fecha_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($hora_err)) ? 'has-error' : ''; ?>">
                            <label>Hora de Ingreso del Articulo</label>
                            <input type="text" name="hora" class="form-control" value="<?php echo $hora; ?>">
                            <span class="help-block"><?php echo $hora_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($cantidad_err)) ? 'has-error' : ''; ?>">
                            <label>Cantidad Ingresada</label>
                            <input type="text" name="cantidad" class="form-control" value="<?php echo $cantidad; ?>">
                            <span class="help-block"><?php echo $cantidad_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($empleado_err)) ? 'has-error' : ''; ?>">
                            <label>Id del Empleado que lo ingreso</label>
                            <input type="text" name="empleado" class="form-control" value="<?php echo $empleado; ?>">
                            <span class="help-block"><?php echo $empleado_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($bodega_err)) ? 'has-error' : ''; ?>">
                            <label>Id de la Bodeda donde se Ingreso</label>
                            <input type="text" name="bodega" class="form-control" value="<?php echo $bodega; ?>">
                            <span class="help-block"><?php echo $bodega_err;?></span>
                        </div>
                        <input type="hidden" name="id_inginv" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>