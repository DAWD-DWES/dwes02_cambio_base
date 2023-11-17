<?php
include_once 'funciones_cambio_base.php';

if (!empty($_POST)) {
    $numero = $_POST['numero'];
    $baseOrigen = $_POST['baseorigen'];
    $baseDestino = $_POST['basedestino'];
    $numeroNuevaBase = x2y($numero, $baseOrigen, $baseDestino);
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
                  action="<?= "{$_SERVER['PHP_SELF']}" ?>" method="POST">                
                <div class="input-seccion">
                    <label for="numero">Número:</label> 
                    <input id="numero" type="text" required pattern="[0-9A-F]*" name="numero" value="<?= ($numero) ?? ''; ?>" />
                </div>
                <div class="input-seccion">
                    <label for="baseorigen">Base Origen (2-16):</label> 
                    <input id="numero" type="number" min="2" max="16" required name="baseorigen" value="<?= ($baseOrigen) ?? ''; ?>" />
                </div>
                <div class="input-seccion">
                    <label for="basedestino">Base Destino (2-16):</label> 
                    <input id="basedestino" type="number" min="2" max="16" required name="basedestino" value="<?= ($baseDestino) ?? ''; ?>" />
                </div>
                <?php if (isset($numeroNuevaBase)): ?>
                    <div class="input-seccion">
                        <label for="numeronuevabase">Número en la nueva Base:</label> 
                        <input id="numeronuevabase" type="text" value="<?= $numeroNuevaBase ?>" readonly/>
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
</html>

