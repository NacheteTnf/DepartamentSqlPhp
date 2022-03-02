<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- Se construye la tabla con la lista de empleados -->
    <table>
        <thead>
            <tr>
                <td>
                    Nº de SS
                </td>
                <td>
                    Nombre
                </td>
                <td>
                    Teléfono
                </td>
                <td>
                    Foto
                </td>
            </tr>
        </thead>
        <tbody>
            <?php
                //Leemos de la base de datos la lista de empleados del departamento $_POST["departamento"]. Este valor viene de la función PedirListaEmpleados a través de la variable parametros
                $conexion = new mysqli("127.0.0.1", "root", "", "empleados");
                $conexion->set_charset("utf8");
                $sql = "select nombre,telefono,dni,NumeroSS,Foto from empleados where IdDepartamento=?";
                $instruccion = $conexion->prepare($sql);
                $instruccion->bind_param("i", $_POST["departamento"]);
                $instruccion->execute();
                $tabla = $instruccion->get_result();
                //Nos recorremos la tabla con los departamentos
                //Obtenemos el siguiente registro no leído de la variable $tabla
                while ($registro = $tabla->fetch_object()) {
                    //capturamos para cada fila (tr - empleado) el evento dobleclick (ondblclick) de tal forma que al hacer doble click se llame a la función PedirListaTareas (dni) a la que le enviamos el DNI del empleado actual. La función PedirListaTareas está en el archivo index_v2.php. El resultado de esta página (HTML, JAVASCRIPT, CSS) se va a volcar sobre la propiedad responseText de la función RecibirListaEmpleados del archivo index_v2.php
                    echo "<tr ondblclick=\"PedirListaTareas('$registro->dni')\"><td>$registro->NumeroSS</td><td>$registro->nombre</td><td>$registro->telefono</td><td><img src='fotos/$registro->Foto'></td></tr>";
                }
            ?>
        </tbody>
    </table>

</body>
</html>