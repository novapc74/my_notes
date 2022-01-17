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

$result = [];

$xml = simplexml_load_string($fileContent);

foreach ($xml->previewpages->page0 as $value) {
    foreach ($value->b2 as $item) {
        if ($item->m12['u'] == '') {
            continue;
        }
        $internalProductCode = $item->m12['u'];
        $productBarcode = codeGeneratorEan13($internalProductCode);
        $productCodeForUKTZED = '';
        $serviceCodeDKPP = '';
        $nameOfGoods = $item->m9['u'];
        $unitCode = '';
        $nameOfTheUnitOfMeasurement = 'шт';
        $price = str_replace(' ', '', mb_substr($item->m10['u'], 0, -7));
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
}

$userFormat = implode("\n", $result);

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


