<?php
$base = 12;
$numero = 51;
$restos = '';
while ($numero >= $base) {
    $resto = $numero % $base;
    if ($resto > 9) {
        $resto = chr(ord('A') + $resto - 10);
    }
    $restos = $resto . $restos;
    $numero = intdiv($numero, $base);
}
$conversion = ((($numero > 9) ? chr(ord('A') + $numero - 10) : $numero) . $restos);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Conversion decimal a base b</title>
    </head>
    <body>
        <h1><?= "El numero convertido es $conversion" ?></h1>
    </body>
</html>

