
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir y mostrar números</title>
</head>
<body>
<?php
// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se subió un archivo correctamente
    if (isset($_FILES["archivo"]) && $_FILES["archivo"]["error"] == UPLOAD_ERR_OK) {
        $nombre_temporal = $_FILES["archivo"]["tmp_name"];

        // Leer el contenido del archivo
        $lineas = file($nombre_temporal, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // Mostrar los números en pantalla
        echo "<h2>Números en el archivo:</h2>";
        echo "<ul>";
        foreach ($lineas as $linea) {
            // Validar que la línea sea un número antes de mostrarlo
            if (is_numeric($linea)) {
                echo "<li>$linea</li>";
            }
        }
        echo "</ul>";
    } else {
        echo "<p>Error al subir el archivo.</p>";
    }
}
?>

<!-- Formulario para subir un archivo -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <label for="archivo">Seleccionar archivo:</label>
    <input type="file" name="archivo" id="archivo" accept=".txt">
    <br>
    <input type="submit" value="Subir y mostrar números">
</form>

</body>
</html>


