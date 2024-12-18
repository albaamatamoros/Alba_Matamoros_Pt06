<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once '../../lib/HybridAuth/vendor/autoload.php';
    require_once '../../model/modelUsuaris.php';

    use Hybridauth\Hybridauth;

    try {
        $config = require '../../lib/HybridAuth/configReddit.php';
        $hybridauth = new Hybridauth($config);
    
        // Autentificacio amb reddit
        $adapter = $hybridauth->authenticate('Reddit');
    
        // Obtenir info usuari reddit
        $userProfile = $adapter->getUserProfile();

        $result = iniciSessio($userProfile->displayName);
        if ($result == false) {
            insertarNouUsuariHybridAuth($userProfile);
        }

        $_SESSION["loginId"] = $result["id_usuari"];
        $_SESSION["loginUsuari"] = $result["usuari"];
        $_SESSION["loginCorreu"] = isset($result["correu"]) && $result["correu"] ? $result["correu"] : "";
        $_SESSION["loginNom"] = isset($result["nom"]) && $result["nom"] ? $result["nom"] : "";
        $_SESSION["loginCognom"] = isset($result["cognoms"]) && $result["cognoms"] ? $result["cognoms"] : "";
        $_SESSION["loginImage"] = $result["imatge"];
        $_SESSION["loginAdministrador"] = $result["administrador"];
        $_SESSION["loginAutentificacio"] = $result["autentificacio"];
    
        // Desconectar al usuario si es necesario
        $adapter->disconnect();
        header('Location: ../../index.php');
    } catch (\Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
?>