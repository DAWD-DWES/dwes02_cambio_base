<?php
$base = 16;
$numero = 'F5';
$conversion = 0;
for ($i = 0; $i < strlen($numero); $i++) {
    $digito = substr(strrev((string) $numero), $i, 1);
        if (!is_numeric($digito)) {
            $digito = (ord($digito) - ord('A') + 10);
        }
        $conversion += $digito * pow($base, $i);
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Conversión de base b a decimal</title>
    </head>
    <body>
        <h1><?= "El número convertido es $conversion" ?></h1>
    </body>
</html>


