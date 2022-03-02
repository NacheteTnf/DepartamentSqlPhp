<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $conexion = new mysqli("127.0.0.1", "root", "", "empleados");
        $conexion->set_charset("utf8");
        $sql = "select * from tareas where DniEmpleado='".$_POST['dni']."'";
        $instruccion = $conexion->prepare($sql);
        $instruccion->execute();
        $tabla = $instruccion->get_result();
        //Nos recorremos la tabla con los departamentos
        //Obtenemos el siguiente registro no leído de la variable $tabla
        while ($registro = $tabla->fetch_object()) {
            echo $registro->nombre . "<br>";
        }
    ?>
</body>
</html>