<?php
include_once 'funciones_cambio_base.php';

define('NUMERO_REQUERIDO', '** Número requerido');
define('NUMERO_INCORRECTO', '** Número incorrecto');
define('DIGITO_SUPERA_BASE', '** Dígito supera la base');
define('BASE_REQUERIDA', '** Base Requerida');
define('BASE_FUERA_LIMITE', '** Base debe estar entre 2 y 16');

if (filter_has_var(INPUT_POST, 'cambiobase')) {
    $numero = filter_input(INPUT_POST, 'numero', FILTER_UNSAFE_RAW);
    $numeroRequeridoError = empty(trim($numero));
    $numeroIncorrectoError = !$numeroRequeridoError && (filter_var($numero, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '/^[0-9A-F]*$/']]) == false);
    $baseOrigen = filter_input(INPUT_POST, 'baseorigen', FILTER_UNSAFE_RAW);
    $baseDestino = filter_input(INPUT_POST, 'basedestino', FILTER_UNSAFE_RAW);
    $baseOrigenRequeridaError = empty(trim($baseOrigen));
    $baseDestinoRequeridaError = empty(trim($baseDestino));
    $baseOrigenFueraLimiteError = !$baseOrigenRequeridaError && (filter_var($baseOrigen, FILTER_VALIDATE_INT, ['options' => ['min_range' => 2, 'max_range' => 16]]) == false);
    $baseDestinoFueraLimiteError = !$baseDestinoRequeridaError && (filter_var($baseDestino, FILTER_VALIDATE_INT, ['options' => ['min_range' => 2, 'max_range' => 16]]) == false);
    $digitoSuperaBaseError = !$numeroRequeridoError && !$numeroIncorrectoError && !$baseOrigenRequeridaError && !$baseOrigenFueraLimiteError &&
            !array_reduce(array_map(function ($posicion) use ($baseOrigen) {
                        return $posicion < $baseOrigen;
                    },
                            array_map(fn($num) => ($num < 10) ? $num : (ord($num) - ord('A') + 10), str_split($numero))),
                    fn($bool1, $bool2) => $bool1 && $bool2,
                    true);

    $error = $numeroRequeridoError || $numeroIncorrectoError ||
            $digitoSuperaBaseError || $baseOrigenRequeridaError ||
            $baseDestinoRequeridaError || $baseOrigenFueraLimiteError || $baseDestinoFueraLimiteError;
    if (!$error) {
        $numeroNuevaBase = x2y($numero, $baseOrigen, $baseDestino);
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
                  action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="input-seccion">
                    <label for="numero">Número:</label> 
                    <input id="numero" type="text" name="numero" value="<?= ($numero) ?? '' ?>" />
                    <?php if ($numeroRequeridoError ?? false) : ?>
                        <div class="error-section">
                            <div class="error"><?= NUMERO_REQUERIDO ?></div>
                        </div>
                    <?php endif ?>
                    <?php if ($numeroIncorrectoError ?? false): ?>
                        <div class="error-section">
                            <div class="error"><?= NUMERO_INCORRECTO ?></div>
                        </div>
                    <?php endif ?>
                    <?php if ($digitoSuperaBaseError ?? false): ?>
                        <div class="error-section">
                            <div class="error"><?= DIGITO_SUPERA_BASE ?></div>
                        </div>
                    <?php endif ?>
                </div>
                <div class="input-seccion">
                    <label for="baseorigen">Base Origen (2-16):</label> 
                    <input id="numero" type="text" name="baseorigen" value="<?= ($baseOrigen) ?? '' ?>" />
                    <?php if ($baseOrigenRequeridaError ?? false): ?>
                        <div class="error-section">
                            <div class="error"><?= BASE_REQUERIDA ?></div>
                        </div>
                    <?php endif ?>
                    <?php if ($baseOrigenFueraLimiteError ?? false): ?>
                        <div class="error-section">
                            <div class="error"><?= BASE_FUERA_LIMITE ?></div>
                        </div>
                    <?php endif ?>
                </div>
                <div class="input-seccion">
                    <label for="basedestino">Base Destino (2-16):</label> 
                    <input id="basedestino" type="number" name="basedestino" value="<?= ($baseDestino) ?? '' ?>" />
                    <?php if ($baseDestinoRequeridaError ?? false): ?>
                        <div class="error-section">
                            <div class="error"><?= BASE_REQUERIDA ?></div>
                        </div>
                    <?php endif ?>
                    <?php if ($baseDestinoFueraLimiteError ?? false): ?>
                        <div class="error-section">
                            <div class="error"><?= BASE_FUERA_LIMITE ?></div>
                        </div>
                    <?php endif ?>
                </div>
                <?php if (isset($numeroNuevaBase)): ?>
                    <div class="input-seccion">
                        <label for="numeronuevabase">Número en la nueva Base:</label> 
                        <input id="numeronuevabase" type="number" value="<?= $numeroNuevaBase ?>" readonly/>
                    </div>
                <?php endif ?> 
                <div class="submit-seccion">
                    <input class="submit" type="submit" 
                           value="Cambio de Base" name="cambiobase" /> 
                </div>
            </form> 
        </div>  
    </body>
</html>

