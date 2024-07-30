<?php
    $json = file_get_contents("data-2.json");
    //print_r($json);

    $data = json_decode($json, true);

    //print_r($data);

    $conexion = mysqli_connect("localhost","root","","inmoviliaria")
        or die ("ERROR EN LA CONEXION");

    foreach($data as $row){

        //print_r($row);

        $id = $row['Id'];
        $direccion = $row['Direccion'];
        $ciudad = $row['Ciudad'];
        $telefono = $row['Telefono'];
        $codPostal = $row['Codigo_Postal'];
        $tipo = $row['Tipo'];
        $precio = $row['Precio'];

        $sql = "INSERT INTO casas VALUES ('$id', '$direccion', '$ciudad', '$telefono', '$codPostal', '$tipo', '$precio')";
        //echo ($sql)."</br>";
        $consulta = mysqli_query($conexion, $sql)
                    or die("Error al extraer los registros");
    }

?>