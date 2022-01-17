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

$xml = simplexml_load_file("/home/novapc74/testStorage/input_data/price.fp3");
$arr = json_decode(json_encode($xml), true);

$pages = $arr['previewpages']['page0'];

$head = implode(';', [
        "Внутрішній код товару",
        "Штриховий код товару",
        "Код товару за УКТЗЕД",
        "Код послуги за ДКПП",
        "Найменування товару",
        "Код одиниці виміру",
        "Найменування одиниці виміру",
        "Ціна (грн)",
        "ПДВ – літера",
        "ПДВ – ставка (%)",
        "Збір – літера",
        "Збір – ставка (%)",
        "Позначка акцизної марки",
    ]
);

$result = [];
$result[] = $head;

foreach ($pages as $page) {
    foreach ($page as $item) {
        foreach ($item as $value) {
            if (!empty($value['m9']['@attributes']['u']) && !empty($value['m10']['@attributes']['u'])) {
                $internalProductCode = $value['m12']['@attributes']['u'];
                $productBarcode = codeGeneratorEan13($value['m12']['@attributes']['u']);
                $productCodeForUKTZED = "";
                $serviceCodeDKPP = "";
                $nameOfgoods = $value['m9']['@attributes']['u'] ?? null;
                $unitCode = "";
                $nameOfTheUnitOfMeasurement = 'шт';
                $price = str_replace(" ", "", mb_substr($value['m10']['@attributes']['u'], 0, -7));
                $letterPDV = "";
                $ratePDV = "";
                $collectionLetter = "";
                $feeRate = "";
                $exciseStampMark = "";

                $test = [
                    $internalProductCode,
                    $productBarcode,
                    $productCodeForUKTZED,
                    $serviceCodeDKPP,
                    $nameOfgoods,
                    $unitCode,
                    $nameOfTheUnitOfMeasurement,
                    $price,
                    $letterPDV,
                    $ratePDV,
                    $collectionLetter,
                    $feeRate,
                    $exciseStampMark,
                ];
                $result[] = '"' . implode('";"', $test) . '"';
            }
        }
    }
}


    $data = implode("\n", $result);
    file_put_contents("/home/novapc74/testStorage/output_data/storage.csv", $data);
