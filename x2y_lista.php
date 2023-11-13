<?php
include_once 'funciones_cambio_base.php';

$numeros = [123, 45, 245];

$baseOrigen = 6;
$baseDestino = 12;

$x2y = function (int $num) use ($baseOrigen, $baseDestino) {
    return dec2x(x2dec($num, $baseOrigen), $baseDestino);
};


$numerosNuevaBase = array_map($x2y, $numeros);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Conversión de base x a base y</title>
    </head>
    <body>
        <h1>Conversión de una lista de números de base x a y</h1>
        <table>
            <thead>
                <tr>
                    <td><?= "Base Origen: $baseOrigen" ?></td>
                    <td><?= "Base Destino: $baseDestino" ?></td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($numeros as $key => $numero): ?>
                    <tr>
                        <td><?= $numeros[$key] ?></td>
                        <td><?= $numerosNuevaBase[$key] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </body>
</html>
