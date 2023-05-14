<?php
// Establish database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "inventario";
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];

  // Query the database for user credentials
  $sql = "SELECT tipo_emp FROM empleados WHERE id_emp = '$username'";
  $result = mysqli_query($conn, $sql);

  // Check if login is successful
  if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    session_start();
    $tipoEmpleado = $row['tipo_emp'];
  if( $tipoEmpleado == "Administrativo"){
    header("Location: admin/"); // Redirect to the dashboard page
    exit();
  }else if( $tipoEmpleado == "Empleado"){
    header("Location: emp/"); // Redirect to the dashboard page
    exit();
  }else if( $tipoEmpleado == "Cliente"){
    header("Location: client/"); // Redirect to the dashboard page
    exit();
  }

  } else {
    $error_message = "Invalid ID";
  }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Confirmacion Id</title>
    <link rel="stylesheet" href="https://getbootstrap.com/docs/5.3/dist/css/bootstrap.min.css">
    <style type="text/css">1
        .wrapper{https://getbootstrap.com/docs/5.3/dist/css/bootstrap.min.css
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<center><form method="post">
    <div class="container mt-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card px-5 py-5" id="form1">
                <div class="form-data" v-if="!submitted">
                  
                    <div class="forms-inputs mb-4"> <span>Ingreses su Id UNICO, Por favor</span> <input autocomplete="off" type="text" name="username"v-model="email" v-bind:class="{'form-control':true, 'is-invalid' : !validEmail(email) && emailBlured}" v-on:blur="emailBlured = true">
                    </div>
                    <div class="mb-3"> <input type="submit" value="Login"> </div>
                </div>
                <div class="success-data" v-else>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php
  if (isset($error_message)) {
    echo "<p>$error_message</p>";
  }
  ?>
</form></center>




  
</body>
</html>