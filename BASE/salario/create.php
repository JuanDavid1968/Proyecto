<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$empleado = $numero = $banco = $salario = $auxilio = $descuentos = $descuentop = "";

$empleado_err = $numero_err = $banco_err = $salario_err = $auxilio_err= $descuentos_err = $descuentop_err = "";

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate empleado
    $input_empleado = trim($_POST["empleado"]);
    if(empty($input_empleado)){
        $empleado_err = "Por favor ingrese el Id del Empleado";
    } else{
        $empleado = $input_empleado;
    }

    // Validate numero
    $input_numero = trim($_POST["numero"]);
    if(empty($input_numero)){
        $numero_err = "Por favor ingrese el numero de cuenta del Empleado";
    } else{
        $numero = $input_numero;
    }

    // Validate banco
    $input_banco = trim($_POST["banco"]);
    if(empty($input_banco)){
        $banco_err = "Por favor ingrese el nombre del banco del Empleado";
    } else{
        $banco = $input_banco;
    }

    // Validate salario
    $input_salario = trim($_POST["salario"]);
    if(empty($input_salario)){
        $salario_err = "Por favor ingrese el monto del salario base del Empleado";
    } else{
        $salario = $input_salario;
    }

    // Validate auxilio
    $input_auxilio = trim($_POST["auxilio"]);
    if(empty($input_auxilio)){
        $auxilio_err = "Por favor ingrese el monto del auxilio de transporte del Empleado";
    } else{
        $auxilio = $input_auxilio;
    }

    // Validate descuentos
    $input_descuentos = trim($_POST["descuentos"]);
    if(empty($input_descuentos)){
        $descuentos_err = "Por favor ingrese el porcentaje decimal del descuento salud del Empleado";
    } else{
        $descuentos = $input_descuentos;
    }

    // Validate banco
    $input_descuentop = trim($_POST["descuentop"]);
    if(empty($input_descuentop)){
        $descuentop_err = "Por favor ingrese el porcentaje decimal del descuento pension del Empleado";
    } else{
        $descuentop = $input_descuentop;
    }

    // Check input errors before inserting in database
    if(empty($empleado_err) && empty($numero_err) && empty($banco_err) && empty($salario_err) &&  empty($auxilio_err) && empty($descuentos_err) && empty($desceuntop_err)){
        // Prepare an update statement
        $sql = "INSERT INTO salario(id_emp, numerocuenta, banco, salariobase, auxiliotransporte, descuentosalud, descuentopension) VALUES (?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_empleado, $param_numero, $param_banco,  $param_salario, $param_auxilio, $param_descuentos, $param_descuentop);
            
            // Set parameters
            $param_empleado = $empleado;
            $param_numero = $numero;
            $param_banco = $banco;
            $param_salario = $salario;
            $param_auxilio = $auxilio;
            $param_descuentos = $descuentos;
            $param_descuentop = $descuentop;
            
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
    <title>Crear Registro de Nomina</title>
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
                        <h2>Crear Registro de Nomina</h2>
                    </div>
                    <p>Favor diligenciar el siguiente formulario, para agregar una nueva nomina.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($empleado_err)) ? 'has-error' : ''; ?>">
                            <label>Id del Empleado</label>
                            <input type="text" name="empleado" class="form-control" value="<?php echo $empleado; ?>">
                            <span class="help-block"><?php echo $empleado_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($numero_err)) ? 'has-error' : ''; ?>">
                            <label>Numero de cuenta del Empleado</label>
                            <input type="text" name="numero" class="form-control" value="<?php echo $numero; ?>">
                            <span class="help-block"><?php echo $numero_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($banco_err)) ? 'has-error' : ''; ?>">
                            <label>Nombre del Banco del Empleado</label>
                            <input type="text" name="banco" class="form-control" value="<?php echo $banco; ?>">
                            <span class="help-block"><?php echo $banco_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($salario_err)) ? 'has-error' : ''; ?>">
                            <label>Salario Base del Empleado</label>
                            <input type="text" name="salario" class="form-control" value="<?php echo $salario; ?>">
                            <span class="help-block"><?php echo $salario_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($auxilio_err)) ? 'has-error' : ''; ?>">
                            <label>Auxilio de Transporte del Empleado</label>
                            <input type="text" name="auxilio" class="form-control" value="<?php echo $auxilio; ?>">
                            <span class="help-block"><?php echo $auxilio_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($descuentos_err)) ? 'has-error' : ''; ?>">
                            <label>Descuento de salud en decimal del Empleado</label>
                            <input type="text" name="descuentos" class="form-control" value="<?php echo $descuentos; ?>">
                            <span class="help-block"><?php echo $descuentos_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($descuentop_err)) ? 'has-error' : ''; ?>">
                            <label>Descuento de pension en decimal del Empleado</label>
                            <input type="text" name="descuentop" class="form-control" value="<?php echo $descuentop; ?>">
                            <span class="help-block"><?php echo $descuentop_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="index.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>