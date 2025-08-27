<?php
header('Content-Type: application/json');

if (!isset($_GET['keys'])) {
    echo json_encode(["error" => "No keys provided"]);
    exit;
}

// دالة لتحويل hex إلى base64
function hexToBase64($hex) {
    return rtrim(strtr(base64_encode(hex2bin($hex)), '+/', '-_'), '=');
}

// استقبال كل المفاتيح
$keysParam = $_GET['keys'];
$pairs = explode(",", $keysParam);

$result = ["keys" => []];

foreach ($pairs as $pair) {
    if (strpos($pair, ":") === false) continue; // تجاهل أي قيمة غير صحيحة
    list($keyid, $key) = explode(":", $pair);

    $result["keys"][] = [
        "kty" => "oct",
        "kid" => hexToBase64(trim($keyid)),
        "k"   => hexToBase64(trim($key))
    ];
}

echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
?>
