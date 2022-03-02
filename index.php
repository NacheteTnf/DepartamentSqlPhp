<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        td{
            border: 1px solid black;
        }
    </style>
</head>
<body>

    <form action="index.php" method="post">
        <select name="departamento" id="" onchange="this.form.submit();">
            <option value="">Elija un departamento</option>
            <?php
                $conexion = new mysqli("127.0.0.1", "root", "", "empleados");
                $conexion->set_charset("utf8");
                $sql = "select * from departamentos";
                $instruccion = $conexion->prepare($sql);
                $instruccion->execute();
                $tabla = $instruccion->get_result();
                //Nos recorremos la tabla con los departamentos
                //Obtenemos el siguiente registro no leído de la variable $tabla
                while ($registro = $tabla->fetch_object()) {
                    //si está establecida el valor de la variable $_POST["departamento"] (venimos de hacer un submit del formulario con la lista de departaments) y el elemento del select que se está creando en este momento coincide con el departamento que seleccionó el usuario pues se deja seleccionado dentro del select
                    if (isset($_POST["departamento"]) && $_POST["departamento"] == $registro->id) {
                        echo "<option selected value='$registro->id'>$registro->nombre</option>";
                    }
                    //sino pues no se deja seleccionado.
                    else {
                        echo "<option value='$registro->id'>$registro->nombre</option>";
                    }
                }
            ?>   
        </select>     
    </form>
    <?php
        //Si la variable existe es porque procede de hacer el submit en el formulario del departamento y sino es porque la página se ha cargado directamente (sin pasar por el formulario)
        if (isset($_POST["departamento"]))
        {
            ?>
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
                    $sql = "select nombre,telefono,dni,NumeroSS,Foto from empleados where IdDepartamento=?";
                    $instruccion = $conexion->prepare($sql);
                    $instruccion->bind_param("i", $_POST["departamento"]);
                    $instruccion->execute();
                    $tabla = $instruccion->get_result();
                    //Nos recorremos la tabla con los departamentos
                    //Obtenemos el siguiente registro no leído de la variable $tabla
                    while ($registro = $tabla->fetch_object()) {
                        echo "<tr ondblclick=\"CargarTareas('$registro->dni')\"><td>$registro->NumeroSS</td><td>$registro->nombre</td><td>$registro->telefono</td><td><img src='fotos/$registro->Foto'></td></tr>";
                    }
                ?>
                </tbody>
            </table>
            
            <form action="index.php" id="formulario" method="post">
                <input type="hidden" name="departamento" value="<?=$_POST['departamento']?>">
                <input type="hidden" name="DniEmpleado" id="DniEmpleado" value="pepe">
            </form>
                        
            
            <?php

            if (isset($_POST["DniEmpleado"])) {
                $sql = "select * from tareas where DniEmpleado='".$_POST['DniEmpleado']."'";
                $instruccion = $conexion->prepare($sql);
                $instruccion->execute();
                $tabla = $instruccion->get_result();
                //Nos recorremos la tabla con los departamentos
                //Obtenemos el siguiente registro no leído de la variable $tabla
                while ($registro = $tabla->fetch_object()) {
                    echo $registro->nombre . "<br>";
                }
            }
        }
        
    ?>

    <script>
        function CargarTareas(dni) {
            formulario = document.getElementById("formulario");
            DniEmpleado = formulario.DniEmpleado;
            DniEmpleado.value = dni;
            formulario.submit();
        }
    </script>
</body>
</html>