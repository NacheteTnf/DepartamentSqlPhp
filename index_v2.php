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
    <!-- Al cambiar el valor del select se llama a la función PedirListaEmpleados enviando el value del option seleccionado (El id del departamento) -->
    <select name="departamento" id="" onchange="PedirListaEmpleados(this.value)">
        <option value="">Elija un departamento</option>
        <?php
            //creamos la conexión con la base de datos
            $conexion = new mysqli("127.0.0.1", "root", "", "empleados");
            //se establece la codificación en español
            $conexion->set_charset("utf8");
            //creamos el sql que selecciona todos los campos de la tabla departamentos
            $sql = "select * from departamentos";
            //Se crea la instrucción para ser ejecutada por el servidor de bases de datos.
            $instruccion = $conexion->prepare($sql);
            //se ejecuta el sql anterior por el servidor de bases de datos
            $instruccion->execute();
            //se recuperan los resultados del servidor de bases de datos en una tabla
            $tabla = $instruccion->get_result();
            
            //Nos recorremos la tabla con los departamentos
            //Obtenemos el siguiente registro no leído de la variable $tabla en la variable $registro
            while ($registro = $tabla->fetch_object()) {
                //Se crea un option del select por cada departamento poniendo como value el id de departamento y como texto el nombre del departamento
                echo "<option value='$registro->id'>$registro->nombre</option>";
            }
        ?>   
    </select>   
    <!--Aqui se volcará la tabla con la lista de empleados-->
    <div id="Empleados">

    </div>
    
    <!--Aqui se volcará la tabla con la lista de tareas-->
    <div id="Tareas">

    </div>

    <script>
        //Esta función se llama cuando se seleccione un departamento desde el select. Se le pasa como parámetro el Id del departamento (variable DepartamentoSeleccionado)
        function PedirListaEmpleados(DepartamentoSeleccionado) {
            //Se crea un objeto (solicitud) de la clase XMLHttpRequest que es el que nos va a permitir comunicarnos en el servidor en segundo plano (2º hilo o proceso)
            solicitud = new XMLHttpRequest();
            //Se le asigna al objeto anterior un manejador de eventos para que cuando se reciban los datos (evento load) se llame a la función RecibirListaEmpleados
            solicitud.addEventListener("load", RecibirListaEmpleados);
            //Se establece conexión con el servidor para que devuelva (cuando se haga el send) la página ObtenerEmpleados.php
            solicitud.open("POST", "ObtenerEmpleados.php", true);

            //Se crea un objeto de la clase FormData que es la que nos va a permitir enviar los parámetros como si fuera un formulario con el method=post
            parametros = new FormData();
            //Se añade el primer parámetro (departamento) con su valor (DepartamentoSeleccionado)
            parametros.append('departamento', DepartamentoSeleccionado);
            //Se pide al servidor que nos devuelva la página ObtenerEmpleados. Para ello le enviamos los parámetros que va a necesitar.
            solicitud.send(parametros);
        }

        //Esta función recibirá la página leída desde el servidor (ObtenerEmpleados.php)
        function RecibirListaEmpleados() {
            //Obtenemos una referencia en la variable DivEmpleados a la etiqueta con el id Empleados (el primer div)
            DivEmpleados = document.getElementById("Empleados");
            //Se escribe en el div (DivEmpleados.innerHTML) lo que recibimos del servidor (la página ObtenerEmpleados.php) a través de la propidad responseText del objeto solicitud (this)
            DivEmpleados.innerHTML = this.responseText;
        }


        function PedirListaTareas (DniEmpleado) {
            solicitud = new XMLHttpRequest();
            solicitud.addEventListener("load", RecibirListaTareas);
            solicitud.open("POST", "ObtenerTareas.php", true);
            parametros = new FormData();
            parametros.append('dni', DniEmpleado);
            solicitud.send(parametros);        
        }

        function RecibirListaTareas() {
            DivTareas = document.getElementById("Tareas");
            DivTareas.innerHTML = this.responseText;
        }

    </script>
        
</body>
</html>