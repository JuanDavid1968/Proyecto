<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$articulo = $fecha = $empleado = $cantidad =  $precio = "";

$articulo_err = $fecha_err = $empleado_err = $cantidad_err = $precio_err = "";

 
// Processing form data when form is submitted
if(isset($_POST["id_fact"]) && !empty($_POST["id_fact"])){
    // Get hidden input value
    $id = $_POST["id_fact"];
    
    // Validate articulo
    $input_articulo = trim($_POST["articulo"]);
    if(empty($input_articulo)){
        $articulo_err = "Por favor ingrese el id del articulo.";
    } else{
        $articulo = $input_articulo;
    }

    // Validate fecha
    $input_fecha = trim($_POST["fecha"]);
    if(empty($input_fecha)){
        $fecha_err = "Por favor ingrese la fecha.";
    } else{
        $fecha = $input_fecha;
    }
    
    // Validate empleado
    $input_empleado  = trim($_POST["empleado"]);
    if(empty($input_empleado)){
        $empleado_err = "Por favor ingrese el id del empleado.";
    } else{
        $empleado = $input_empleado;
    }

    // Validate cantidad
    $input_cantidad  = trim($_POST["cantidad"]);
    if(empty($input_cantidad)){
        $cantidad_err = "Por favor ingrese la cantidad.";
    } else{
        $cantidad = $input_cantidad;
    }

    // Validate precio
    $input_precio  = trim($_POST["precio"]);
    if(empty($input_precio)){
        $precio_err = "Por favor el precio total.";
    } else{
        $precio = $input_precio;
    }
    
    // Check input errors before inserting in database
    if(empty($articulo_err) && empty($fecha_err) && empty($empleado_err) && empty($cantidad_err) && empty($precio_err) ){
        // Prepare an update statement
        $sql = "UPDATE factura SET id_art=?, fecha_fact=?, id_emp=?, cantidad=?, precio_fac=? WHERE id_fact=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_articulo, $param_fecha, $param_empleado, $param_cantidad,  $param_precio, $param_id);
            
            // Set parameters
            $param_articulo= $articulo;
            $param_fecha = $fecha;
            $param_empleado = $empleado;
            $param_cantidad = $cantidad;
            $param_precio = $precio;
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
    if(isset($_GET["id_fact"]) && !empty(trim($_GET["id_fact"]))){
        // Get URL parameter
        $id =  trim($_GET["id_fact"]);
        // Prepare a select statement
        $sql = "SELECT * FROM factura WHERE id_fact= ?";
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
                    $fecha = $row["fecha_fact"];
                    $empleado = $row["id_emp"];
                    $cantidad = $row["cantidad"];
                    $precio = $row["precio_fac"];
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
    <title>Actualizar Registro de Facturas</title>
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
                        <h2>Actualizar Registro de Factura</h2>
                    </div>
                    <p>Edite los valores de entrada y envíe para actualizar el registro.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($articulo_err)) ? 'has-error' : ''; ?>">
                            <label>Id del articulo</label>
                            <input type="text" name="articulo" class="form-control" value="<?php echo $articulo; ?>">
                            <span class="help-block"><?php echo $articulo_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($fecha_err)) ? 'has-error' : ''; ?>">
                            <label>Fecha</label>
                            <input type="text" name="fecha" class="form-control" value="<?php echo $fecha; ?>">
                            <span class="help-block"><?php echo $fecha_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($empleado_err)) ? 'has-error' : ''; ?>">
                            <label>Id del empleado</label>
                            <input type="text" name="empleado" class="form-control" value="<?php echo $empleado; ?>">
                            <span class="help-block"><?php echo $empleado_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($cantidad_err)) ? 'has-error' : ''; ?>">
                            <label>Cantidad Faturada</label>
                            <input type="text" name="cantidad" class="form-control" value="<?php echo $cantidad; ?>">
                            <span class="help-block"><?php echo $cantidad_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($precio_err)) ? 'has-error' : ''; ?>">
                            <label>Precio de la Factura</label>
                            <input type="text" name="precio" class="form-control" value="<?php echo $precio; ?>">
                            <span class="help-block"><?php echo $precio_err;?></span>
                        </div>
                        <input type="hidden" name="id_fact" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>