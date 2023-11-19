<?php
$base = 12;
$numero = 123;
$conversion = '';
while ($numero > 0) {
    $resto = $numero % $base;
    if ($resto > 9) {
        $resto = chr(ord('A') + $resto - 10);
    }
    $conversion = $resto . $conversion;
    $numero = intdiv($numero, $base);
}
$conversion = $conversion ?: 0;


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

