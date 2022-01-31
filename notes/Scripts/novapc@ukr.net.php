<?php
// input file $fileContent (string), out file - $userFormat (string);
function codeGeneratorEan13($num): string
{
    $middle = implode('', array_fill(1, 11 - strlen($num), 0));
    $code = "2{$middle}{$num}";

    $evenKeys = [];
    $oddKeys = [];
    for ($i = 0, $count = strlen($code); $i < $count; $i++) {
        $i % 2 !== 0 ? $evenKeys[] = $code[$i] : $oddKeys[] = $code[$i];
    }

    $result = array_sum($evenKeys) * 3 + array_sum($oddKeys);
    $checksum = ceil($result/10)*10 - $result;

    return "{$code}{$checksum}";
}

$file = file_get_contents(__DIR__ . "/testStorage/input_data/Otchet_inventarizaciya.csv");
$fileConverted = iconv('windows-1251', 'utf-8', $file);

$fileData = explode(PHP_EOL, $fileConverted);
$result = [];

for ($i = 2, $count = count($fileData); $i < $count; $i++) {
    $item = explode(";", $fileData[$i]);
    $internalProductCode = $item[1];
    $productBarcode = codeGeneratorEan13($item[1]);
    $productCodeForUKTZED = '';
    $serviceCodeDKPP = '';
    $nameOfGoods = $item[3];
    $unitCode = '';
    $nameOfTheUnitOfMeasurement = 'шт';
    $price = str_replace(' ', '', mb_substr($item[5], 0, -7));
    $letterPDV = '';
    $ratePDV = '';
    $collectionLetter = '';
    $feeRate = '';
    $exciseStampMark = '';

    $dataItem = [
        $internalProductCode,
        $productBarcode,
        $productCodeForUKTZED,
        $serviceCodeDKPP,
        $nameOfGoods,
        $unitCode,
        $nameOfTheUnitOfMeasurement,
        $price,
        $letterPDV,
        $ratePDV,
        $collectionLetter,
        $feeRate,
        $exciseStampMark,
    ];
    $result[] = implode(';', $dataItem);
}

$userFormat = implode("\n", $result);
echo $userFormat;

//    $headings = [
//        "Внутрішній код товару",
//        "Штриховий код товару",
//        "Код товару за УКТЗЕД",
//        "Код послуги за ДКПП",
//        "Найменування товару",
//        "Код одиниці виміру",
//        "Найменування одиниці виміру",
//        "Ціна (грн)",
//        "ПДВ – літера",
//        "ПДВ – ставка (%)",
//        "Збір – літера",
//        "Збір – ставка (%)",
//        "Позначка акцизної марки",
//    ];
//    $tableHead = implode(';', $headings);
//    $result[] = $tableHead;
