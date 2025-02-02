<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../lib/chillerlan/vendor/autoload.php';
require_once "../model/modelPersonatges.php";
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"] ?? "";
    $cos = $_POST["text"] ?? "";
    $checkBoxNom = $_POST["copiarNom"] ?? "";
    $checkBoxCos = $_POST["copiarText"] ?? "";

    $optionsFormat = new QROptions([
        'outputType' => QRCode::OUTPUT_IMAGE_PNG, //Format png.
    ]);

    $qrUrl = "http://localhost/Practiques/Alba_Matamoros_Pt06/vista/vistaInserir.php";

    if ($checkBoxNom != "" && $checkBoxCos == "") {
        $qr = ($qrUrl . "?nom=" . urlencode($nom));
        echo("<img src=".(new QRCode(options: $optionsFormat))->render($qr).">");
    } elseif ($checkBoxCos != "" && $checkBoxNom == "") {
        $qr = ($qrUrl . "?cos=" . urlencode($cos));
        echo("<img src=".(new QRCode(options: $optionsFormat))->render($qr).">");
    } elseif ($checkBoxCos != "" && $checkBoxNom != "") {
        $qr = ($qrUrl . "?nom=" . urlencode($nom) . "&cos=" . urlencode($cos));
        echo("<img src=".(new QRCode(options: $optionsFormat))->render($qr).">");
    } else {
        $errors[] = "Has de seleccionar alguna opció.";
    }

    if (!empty($errors)) { echo "Has de seleccionar alguna opció."; }
}

function dadesPersonatge($idPersonatge) {
    return selectPersonatgePerId($idPersonatge);
}
