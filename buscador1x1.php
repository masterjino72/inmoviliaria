
<?php
    $conexion = mysqli_connect("localhost","root","","inmoviliaria")
        or die ("ERROR EN LA CONEXION");
    
    $consulta = mysqli_query($conexion, "SELECT * FROM casas")
        or die("Error al extraer los registros");

    if (isset($_POST['submit'])){    
        $ciudad = $_POST['ciudad'];
        $tipo = $_POST['tipo'];
        $precio = $_POST['precio'];
        $pos = strpos($precio, ";");
        $min = substr($precio, 0,$pos);
        $max = substr($precio, $pos+1);
        $min = intval($min);
        $max = intval($max);

       //echo "█ Ciudad: ".$ciudad." █ <<>> Tipo: ".$tipo." █ <<>> Rango de Precios: ".$precio."<br>";

       if(!empty($ciudad) && empty($tipo)){
           //echo "█ Ciudad: ".$ciudad." █ Rango de Precios: ".$precio."<br>";
           printf("█ Ciudad: %s █ Rango de Precios: %s<br>", htmlspecialchars($ciudad), htmlspecialchars($precio));
           $consultavista ="SELECT * FROM casas WHERE Ciudad = '$ciudad' AND Precio > '$min' AND Precio < '$max' ORDER BY id ASC";
            $consulta = mysqli_query($conexion, $consultavista)
                    or die("Error al extraer los registros");
        }
        if(empty($ciudad) && !empty($tipo)){
            //echo "█ Tipo: ".$tipo." █ Rango de Precios: ".$precio."<br>";
            printf("█ Tipo: %s █ Rango de Precios: %s<br>", htmlspecialchars($tipo), htmlspecialchars($tipo));
            $consultavista ="SELECT * FROM casas WHERE Tipo = '$tipo' AND Precio > '$min' AND Precio < '$max' ORDER BY id ASC";
            $consulta = mysqli_query($conexion, $consultavista)
                    or die("Error al extraer los registros");
        }
        if(!empty($ciudad) && !empty($tipo)){
            // Asegúrate de que las variables están definidas antes de usarlas
            $ciudad = isset($ciudad) ? htmlspecialchars($ciudad, ENT_QUOTES, 'UTF-8') : '';
            $tipo = isset($tipo) ? htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8') : '';
            $precio = isset($precio) ? htmlspecialchars($precio, ENT_QUOTES, 'UTF-8') : '';
            // Usa printf para un formato más limpio
            printf("█ Ciudad: %s █ Tipo: %s █ Rango de Precios: %s<br>", $ciudad, $tipo, $precio);
            //echo "█ Ciudad: ".$ciudad." █ Tipo: ".$tipo." █ Rango de Precios: ".$precio."<br>";
            $consultavista ="SELECT * FROM casas WHERE Ciudad = '$ciudad' AND Tipo = '$tipo' AND Precio > '$min' AND Precio < '$max' ORDER BY id ASC";
            $consulta = mysqli_query($conexion, $consultavista)
                    or die("Error al extraer los registros");
        }
        if(empty($ciudad) && empty($tipo)){
            //echo "█ Rango de Precios: ".$precio."<br>";
            // Asegúrate de que la variable está definida antes de usarla
            $precio = isset($precio) ? htmlspecialchars($precio, ENT_QUOTES, 'UTF-8') : '';
            
            // Usa printf para un formato más limpio y claro
            printf("█ Rango de Precios: %s<br>", $precio);
            $consultavista ="SELECT * FROM casas WHERE Precio > '$min' AND Precio < '$max' ORDER BY id ASC";
            $consulta = mysqli_query($conexion, $consultavista)
                    or die("Error al extraer los registros");
        }

        echo '<table class="table table-responsive" border="3">';           
                while ($lista=$consulta->fetch_row()) {
                    echo '<td width="20%">
                            <img src="img/home.jpg" width="250" height="200">
                        </td>';
                    echo '<th width="15%">
                        id<br>
                        Dirección<br>
                        Ciudad<br>
                        Telefono<br>
                        Código Postal<br>
                        Tipo<br>
                        Precio<br>
                    ';
                    echo '</th>';
                    echo '<td>
                        '.$lista[0].'<br>
                        '.$lista[1].'<br>
                        '.$lista[2].'<br>
                        '.$lista[3].'<br>
                        '.$lista[4].'<br>
                        '.$lista[5].'<br>
                        '.$lista[6].'<br>
                        </td>';
                    echo '<tr>';
                        
                } 
        echo '</table>';
    } // if post
    mysqli_close($conexion);
?>
