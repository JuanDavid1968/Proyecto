<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$articulo = $fecha = $empleado = $cantidad =  $precio = "";

$articulo_err = $fecha_err = $empleado_err = $cantidad_err = $precio_err = "";

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

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
        $sql = "INSERT INTO factura (id_art, fecha_fact, id_emp, cantidad, precio_fac) VALUES (?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_articulo, $param_fecha, $param_empleado, $param_cantidad,  $param_precio);
            
            // Set parameters
            $param_articulo= $articulo;
            $param_fecha= $fecha;
            $param_empleado = $empleado;
            $param_cantidad = $cantidad;
            $param_precio = $precio;
            
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
                    <p>Favor diligenciar el siguiente formulario, para agregar una nueva factura.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                       
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

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
