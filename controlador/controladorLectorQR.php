<?php
    // Alba Matamoros Morales
    require_once '../lib/chillerlan/vendor/autoload.php';
    use chillerlan\QRCode\QRCode;
    use chillerlan\QRCode\QROptions;

    // Inicialitzem les variables per gestionar errors i enllaços
    $errors = [];
    $correcte = "";
    $linkQR = "";

    // Comprovem si el formulari s'ha enviat i si hi ha un fitxer d'imatge QR
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imatgeQR'])) {
        $imatgeQR = $_FILES['imatgeQR']['tmp_name'];
        $fitxerTipus = mime_content_type($imatgeQR); // Comprovem el tipus MIME de l'arxiu

        try {
            if (!in_array($fitxerTipus, ['image/png', 'image/jpeg'])) {
                $errors[] = "Només es poden llegir imatges PNG o JPG.";
            }
            
            if (!$imatgeQR) {
                $errors[] = "No existeix cap QR per llegir.";
            }
    
            if (!empty($errors)) {
                include "../vista/vistaLectorQR.php";
                exit; 
            }

            $options = new QROptions();
            // Llegim el contingut del codi QR des del fitxer
            $linkQR = (new QRCode($options))->readFromFile($imatgeQR);
        
            // Comprovem que el contingut del QR sigui vàlid.
            if (empty($linkQR)) {
                $errors[] = "El codi QR no és vàlid.";
                $linkQR = "";
            } else {
                // Comprovem si l'enllaç QR comença amb "http://localhost/Practiques/Alba_Matamoros_Pt06"
                if (strpos($linkQR, "http://localhost/Practiques/Alba_Matamoros_Pt06") === 0) {
                    header("Location: " . $linkQR);
                    exit;
                } else {
                    $errors[] = "El codi QR no pertany a aquest lloc web.";
                    $linkQR = "";
                }
            }
    
            include "../vista/vistaLectorQR.php";
        } catch (Exception $e) {
            $errors[] = "S'ha produït un error no controlat: " . $e->getMessage();
            include "../vista/vistaLectorQR.php";
        }
    }
?>
