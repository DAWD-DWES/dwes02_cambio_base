<?php
include_once 'funciones_cambio_base.php';

define('BASE_REQUERIDA', '** Base Requerida');
define('BASE_FUERA_LIMITE', '** Base debe estar entre 2 y 16');

if (filter_has_var(INPUT_POST, 'cambiobase')) {
    if (isset($_FILES["ficheronumeros"]) && $_FILES["ficheronumeros"]["error"] == UPLOAD_ERR_OK) {
        $nombre_temporal = $_FILES["ficheronumeros"]["tmp_name"];

// Leer el contenido del archivo
        $numeros = file($nombre_temporal, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    } else {
        $ficheroError = true;
    }
    $numeroRequeridoError = empty(trim($numero));
    $numeroIncorrectoError = !$numeroRequeridoError && (filter_var($numero, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[0-9A-F]*$/']]) == false);
    $baseOrigen = filter_input(INPUT_POST, 'baseorigen');
    $baseDestino = filter_input(INPUT_POST, 'basedestino');
    $baseOrigenRequeridaError = empty(trim($baseOrigen));
    $baseDestinoRequeridaError = empty(trim($baseDestino));
    $baseOrigenFueraLimiteError = !$baseOrigenRequeridaError && (filter_var($baseOrigen, FILTER_VALIDATE_INT, ['options' => ['min_range' => 2, 'max_range' => 16]]) == false);
    $baseDestinoFueraLimiteError = !$baseDestinoRequeridaError && (filter_var($baseDestino, FILTER_VALIDATE_INT, ['options' => ['min_range' => 2, 'max_range' => 16]]) == false);
    $digitoSuperaBaseError = !$numeroRequeridoError && !$numeroIncorrectoError && !$baseOrigenRequeridaError && !$baseOrigenFueraLimiteError &&
            !array_reduce(array_map(function ($posicion) use ($baseOrigen) {
                        return $posicion < $baseOrigen;
                    }, array_map(fn($num) => ($num < 10) ? $num : (ord($num) - ord('A') + 10), str_split($numero))),
                    fn($bool1, $bool2) => $bool1 && $bool2,
                    true);

    $error = $ficheroError || $numeroRequeridoError || $numeroIncorrectoError ||
            $digitoSuperaBaseError || $baseOrigenRequeridaError ||
            $baseDestinoRequeridaError || $baseOrigenFueraLimiteError || $baseDestinoFueraLimiteError;
    if (!$error) {
        $numerosFiltrados = array_filter($numeros, fn($numero) => preg_match('/^[0-9A-F]*$/', $numero));
        $numerosNuevaBase = array_map(function ($numero) use ($baseOrigen, $baseDestino) {
            return x2y($numero, $baseOrigen, $baseDestino);
        }, $numerosFiltrados);
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="stylesheet.css">
        <title>Conversión de base x a base y</title>
    </head>
    <body>
        <div class="page">
            <h1>Aplicación de cambio de base</h1>
            <form class="form" name="form_cambio_de_base" 
                  action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                <div class="input-seccion">
                    <label for="fichero">Fichero Números:</label> 
                    <input id="fichero" type="file" name="ficheronumeros" accept=".txt" />
                </div>
                <div class="input-seccion">
                    <label for="baseorigen">Base Origen (2-16):</label> 
                    <input id="numero" type="number" name="baseorigen" value="<?= ($baseOrigen) ?? '' ?>" />
                    <?php if ($baseOrigenRequeridaError ?? false): ?>
                        <div class="error-section">
                            <div class="error"><?= constant("BASE_REQUERIDA") ?></div>
                        </div>
                    <?php endif ?>
                    <?php if ($baseOrigenFueraLimiteError ?? false): ?>
                        <div class="error-section">
                            <div class="error"><?= constant("BASE_FUERA_LIMITE") ?></div>
                        </div>
                    <?php endif ?>
                </div>
                <div class="input-seccion">
                    <label for="basedestino">Base Destino (2-16):</label> 
                    <input id="basedestino" type="number" name="basedestino" value="<?= ($baseDestino) ?? ''; ?>" />
                    <?php if ($baseDestinoRequeridaError ?? false): ?>
                        <div class="error-section">
                            <div class="error"><?= constant("BASE_REQUERIDA") ?></div>
                        </div>
                    <?php endif ?>
                    <?php if ($baseDestinoFueraLimiteError ?? false): ?>
                        <div class="error-section">
                            <div class="error"><?= constant("BASE_FUERA_LIMITE") ?></div>
                        </div>
                    <?php endif ?>
                </div>
                <table>
                    <thead>
                        <tr>
                            <td><?= "Base Origen: $baseOrigen" ?></td>
                            <td><?= "Base Destino: $baseDestino" ?></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($numerosFiltrados as $key => $numero): ?>
                            <tr>
                                <td><?= $numerosFiltrados[$key] ?></td>
                                <td><?= $numerosNuevaBase[$key] ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <div class="submit-seccion">
                    <input class="submit" type="submit" 
                           value="Cambio de Base" name="cambiobase" /> 
                </div>

            </form> 
        </div>  
    </body>
</html>
</html>

