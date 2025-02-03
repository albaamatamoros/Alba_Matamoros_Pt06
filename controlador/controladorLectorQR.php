<?php
    require_once '../lib/chillerlan/vendor/autoload.php';
    use chillerlan\QRCode\QRCode;
    use chillerlan\QRCode\QROptions;

    $errors = [];
    $correcte = "";
    $linkQR = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imatgeQR'])) {
        $imatgeQR = $_FILES['imatgeQR']['tmp_name'];

        try {
            if (!$imatgeQR) {
                $errors[] = "No existeix cap QR per llegir.";
            }
    
            $options = new QROptions();
            $linkQR = (new QRCode($options))->readFromFile($imatgeQR);
    
            // https://albamatamoros.es
    
            if (strpos($linkQR, "http://localhost") === 0) {
                header("Location: " . $linkQR);
            } else {
                $errors[] = "El codi QR no pertany a aquest lloc web.";
                $linkQR = "";
            }
    
            include "../vista/vistaLectorQR.php";
        } catch (Exception $e) {
            $errors[] = "S'ha produït un error inesperat.";
        }
    }
?>