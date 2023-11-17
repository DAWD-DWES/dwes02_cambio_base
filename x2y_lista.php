<?php
include_once 'funciones_cambio_base.php';

$numeros = ['123', '45', '245', 'AE5', 'GT7'];

$baseOrigen = 6;
$baseDestino = 12;

$x2y = function (string $num) use ($baseOrigen, $baseDestino) {
    return dec2x(x2dec($num, $baseOrigen), $baseDestino);
};

// $pattern = '[0-' . (($baseOrigen < 10) ? "$baseOrigen" : '9,A' . 


$numerosFiltrados = array_filter($numeros, fn($numero) => preg_match('/^[0-9A-F]*$/', $numero));

$numerosNuevaBase = array_map($x2y, $numerosFiltrados);

$total = array_reduce($numerosNuevaBase, function(string $num1, string $num2) use ($baseDestino, $baseOrigen){
        return(dec2x(x2dec($num1, $baseOrigen) + x2dec($num2, $baseOrigen), $baseDestino));
        }, 0);
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
                <?php foreach ($numerosFiltrados as $key => $numero): ?>
                    <tr>
                        <td><?= $numeros[$key] ?></td>
                        <td><?= $numerosNuevaBase[$key] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <h2><?= "La suma de todos los números es $total" ?></h2>
    </body>
</html>
