<?php

function codeGeneratorEan13($num)
{
    $code = [2, ...array_fill(1, 11 - strlen($num), 0), $num];
    $code = implode("", $code);

    $evenKeys = [];
    $oddKeys = [];
    for ($i = 0, $count = strlen($code); $i < $count; $i++) {
        $i % 2 !== 0 ? $evenKeys[] = $code[$i] : $oddKeys[] = $code[$i];
    }

    $result = array_sum($evenKeys) * 3 + array_sum($oddKeys);
    $firstNum = ceil($result/10)*10;
    $checksum =  $firstNum - $result;

    return $code .= $checksum;
}

$num = 134;
$code = codeGeneratorEan13($num);

var_dump($code);
