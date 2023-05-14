<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$direccion = $barrio = $ciudad = $pais = "";
$direccion_err = $barrio_err = $ciudad_err = $pais_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate direccion
    $input_direccion = trim($_POST["direccion"]);
    if(empty($input_direccion)){
        $direccion_err = "Por favor ingrese la direccion de la Bodega.";
    } else{
        $direccion = $input_direccion;
    }
    
    // Validate barrio
    $input_barrio = trim($_POST["barrio"]);
    if(empty($input_barrio)){
        $barrio_err = "Por favor el Barrio de la Bodega.";     
    } else{
        $barrio = $input_barrio;
    }
    
    // Validate ciudad
    $input_ciudad = trim($_POST["ciudad"]);
    if(empty($input_ciudad)){
        $ciudad_err = "Por favor ingrese la ciudad donde se encuentra la bodega.";     
    } else{
        $ciudad = $input_ciudad;
    }

    // Validate pais
    $input_pais = trim($_POST["pais"]);
    if(empty($input_pais)){
        $pais_err = "Por favor ingrese el pais donde se encuentra la Bodega.";     
    } else{
        $pais = $input_pais;
    }
    



    // Check input errors before inserting in database
    if(empty($direccion_err) && empty($barrio_err) && empty($ciudad_err) && empty($pais_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO bodega (direccion_bod, barrio_bod, ciudad_bod, pais_bod) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_direccion, $param_barrio, $param_ciudad, $param_pais);
            
            // Set parameters
            $param_direccion = $direccion;
            $param_barrio = $barrio;
            $param_ciudad = $ciudad;
            $param_pais = $pais;
            
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
    <title>Agregar Nueva Bodega</title>
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
                        <h2>Agregar Bodega</h2>
                    </div>
                    <p>Favor diligenciar el siguiente formulario, para agregar la nueva Bodega.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($direccion_err)) ? 'has-error' : ''; ?>">
                            <label>Direccion de la bodega</label>
                            <input type="text" name="direccion" class="form-control" value="<?php echo $direccion; ?>">
                            <span class="help-block"><?php echo $direccion_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($barrio_err)) ? 'has-error' : ''; ?>">
                            <label>Barrio donde se encuentra la Bodega</label>
                            <input type="text" name="barrio" class="form-control" value="<?php echo $barrio; ?>">
                            <span class="help-block"><?php echo $barrio_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($ciudad_err)) ? 'has-error' : ''; ?>">
                            <label>Ciudad donde se encuentra la Bodega</label>
                            <input type="text" name="ciudad" class="form-control" value="<?php echo $ciudad; ?>">
                            <span class="help-block"><?php echo $ciudad_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($pais_err)) ? 'has-error' : ''; ?>">
                            <label>Pais donde se encuentra la Bodega</label>
                            <input type="text" name="pais" class="form-control" value="<?php echo $pais; ?>">
                            <span class="help-block"><?php echo $pais_err;?></span>
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