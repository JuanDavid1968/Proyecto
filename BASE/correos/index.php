<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Correos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Correos Actuales</h2>
                        
                        <a href="create.php" class="btn btn-success pull-right">Agregar Nuevo Correo</a>
                        
                    </div>
                    <form action="index.php" method="POST">
                        <input type="text" name="buscar">
                        <input type="submit" value="buscar">
                    </form>
                     
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    if(!isset($_POST['buscar'])){

                    $_POST['buscar'] = "";
                    $buscar = $_POST['buscar'];


                    }

                    // Attempt select query execution
                    $buscar = $_POST['buscar'];
                    $sql = "SELECT * FROM correos WHERE id_cor LIKE '%".$buscar."%' OR id_emp LIKE '%".$buscar."%' OR correo LIKE '%".$buscar."%'";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Id del Correo</th>";
                                        echo "<th>Id del Empleado</th>";
                                        echo "<th>Correo del Empleado</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id_cor'] . "</td>";
                                        echo "<td>" . $row['id_emp'] . "</td>";
                                        echo "<td>" . $row['correo'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='read.php?id_cor=". $row['id_cor'] ."' title='Ver' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='update.php?id_cor=". $row['id_cor'] ."' title='Actualizar' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='delete.php?id_cor=". $row['id_cor'] ."' title='Borrar' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
    <center><a href="../index.html" class="btn btn-success pull-center">Volver a menu principal</a></center>
</body>
</html>