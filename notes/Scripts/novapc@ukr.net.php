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

<<<<<<< HEAD
$fileContent = file_get_contents(__DIR__ . "/testStorage/input_data/store.csv");

$file = iconv('windows-1251', 'utf-8', $fileContent);

$result = [];
$collectionStore = explode(PHP_EOL, $file);

for ($i = 2, $count = count($collectionStore); $i < $count - 1; $i++) {
    
    $item = explode(';', $collectionStore[$i]);

=======
$file = file_get_contents(__DIR__ . "/testStorage/input_data/Otchet_inventarizaciya.csv");
$fileConverted = iconv('windows-1251', 'utf-8', $file);

$fileData = explode(PHP_EOL, $fileConverted);
$result = [];

for ($i = 2, $count = count($fileData); $i < $count; $i++) {
    $item = explode(";", $fileData[$i]);
>>>>>>> 74ebdf963ba99787b536e0bb9f60a9a0344e7f32
    $internalProductCode = $item[1];
    $productBarcode = codeGeneratorEan13($item[1]);
    $productCodeForUKTZED = '';
    $serviceCodeDKPP = '';
    $nameOfGoods = $item[3];
    $unitCode = '';
    $nameOfTheUnitOfMeasurement = 'шт';
<<<<<<< HEAD
    $price = mb_substr($item[8], 0, -7);;
=======
    $price = str_replace(' ', '', mb_substr($item[5], 0, -7));
>>>>>>> 74ebdf963ba99787b536e0bb9f60a9a0344e7f32
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
<<<<<<< HEAD
    if ($dataItem[0] == 0) {
        continue;
    }
    $result[] = implode(';', $dataItem);
}

$userFormat = implode(PHP_EOL, $result);
=======
    $result[] = implode(';', $dataItem);
}

$userFormat = implode("\n", $result);
>>>>>>> 74ebdf963ba99787b536e0bb9f60a9a0344e7f32
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
