<?php
// Establece la conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "inmoviliaria")
    or die("ERROR EN LA CONEXION");

// Verifica si se ha enviado el formulario
if (isset($_POST['submit'])) {
    // Obtiene y sanitiza las entradas del usuario
    $ciudad = isset($_POST['ciudad']) ? htmlspecialchars(trim($_POST['ciudad']), ENT_QUOTES, 'UTF-8') : '';
    $tipo = isset($_POST['tipo']) ? htmlspecialchars(trim($_POST['tipo']), ENT_QUOTES, 'UTF-8') : '';
    $precio = isset($_POST['precio']) ? htmlspecialchars(trim($_POST['precio']), ENT_QUOTES, 'UTF-8') : '';

    // Divide el rango de precios en mínimo y máximo
    $pos = strpos($precio, ";");
    $min = substr($precio, 0, $pos);
    $max = substr($precio, $pos + 1);
    $min = intval($min);
    $max = intval($max);

    // Prepara la consulta SQL
    $sql = "SELECT * FROM casas WHERE Precio > ? AND Precio < ?";
    $params = [$min, $max];
    
    if (!empty($ciudad) && empty($tipo)) {
        $sql .= " AND Ciudad = ?";
        $params[] = $ciudad;
    } elseif (empty($ciudad) && !empty($tipo)) {
        $sql .= " AND Tipo = ?";
        $params[] = $tipo;
    } elseif (!empty($ciudad) && !empty($tipo)) {
        $sql .= " AND Ciudad = ? AND Tipo = ?";
        $params[] = $ciudad;
        $params[] = $tipo;
    }

    $sql .= " ORDER BY id ASC";
    
    // Prepara y ejecuta la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . mysqli_error($conexion));
    }
    
    // Determina el tipo de datos de los parámetros (s = string, i = integer)
    $types = str_repeat('i', count($params) - 2) . str_repeat('s', count($params) - 2);
    mysqli_stmt_bind_param($stmt, $types, ...$params);

    // Ejecuta la consulta
    mysqli_stmt_execute($stmt);
    
    // Obtiene los resultados
    $resultado = mysqli_stmt_get_result($stmt);

    // Imprime los resultados en una tabla
    echo '<table class="table table-responsive" border="3">';
    echo '<tr>
            <th width="20%">Imagen</th>
            <th width="15%">ID<br>Dirección<br>Ciudad<br>Teléfono<br>Código Postal<br>Tipo<br>Precio</th>
            <th>Detalles</th>
          </tr>';
    while ($lista = mysqli_fetch_assoc($resultado)) {
        echo '<tr>';
        echo '<td width="20%">
                <img src="img/home.jpg" width="250" height="200">
              </td>';
        echo '<td width="15%">
                ' . htmlspecialchars($lista['id']) . '<br>
                ' . htmlspecialchars($lista['direccion']) . '<br>
                ' . htmlspecialchars($lista['ciudad']) . '<br>
                ' . htmlspecialchars($lista['telefono']) . '<br>
                ' . htmlspecialchars($lista['codigo_postal']) . '<br>
                ' . htmlspecialchars($lista['tipo']) . '<br>
                ' . htmlspecialchars($lista['precio']) . '
              </td>';
        echo '<tr>';
    }
    echo '</table>';

    // Cierra la sentencia y la conexión
    mysqli_stmt_close($stmt);
    mysqli_close($conexion);
}
?>

