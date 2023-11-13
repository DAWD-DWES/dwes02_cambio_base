<?php

// Funciones de cambio de base de decimal a base X y de base X a decimal

/**
 * Función que realiza el cambio de base de un número de base 10 a otra base
 * 
 * @param int $numero Número que se desea cambia de base
 * @param int $base Base a la que se va a cambiar
 * @return int Número expresado en la nueva base
 */
function dec2x(mixed $numero, int $base): mixed {
    $restos = '';
    while ($numero >= $base) {
        $resto = $numero % $base;
        if ($resto>9) { 
            $resto = chr(ord('A') + $resto - 10);
        }
        $restos = $resto . $restos;
        $numero = intdiv($numero, $base);
    }
    return ( ((($numero > 9) ? chr(ord('A') + $numero - 10) : $numero) . $restos));
}

/**
 * Función que realiza el cambio de base de un número de base 10 a otra base
 * 
 * @param int $numero Número que se desea cambia de base
 * @param int $base Base a la que se va a cambiar
 * @return int Número expresado en la nueva base
 */
function x2dec(mixed $numero, int $base): mixed {
    $conversion = 0;
    for ($i = 0; $i < strlen($numero); $i++) {
        $digito = substr(strrev((string) $numero), $i, 1);
        if (!is_numeric($digito)) {
            $digito = (ord($digito) - ord('A') + 10);
        }
        $conversion += $digito * pow($base, $i);
    }
    return ($conversion);
}
