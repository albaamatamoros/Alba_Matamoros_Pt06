<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require "../../lib/OAuth/vendor/autoload.php";
    require_once '../../model/modelUsuaris.php';

    $client = new Google\Client;

    $client->setClientId(ID_GOOGLE_LOCALHOST);
    $client->setClientSecret(SECRET_GOOGLE_LOCALHOST);
    $client->setRedirectUri(URL_GOOGLE_LOCALHOST);

    if ( ! isset($_GET["code"])) {

        exit("Login failed");

    }

    $token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);

    $client->setAccessToken($token["access_token"]);

    $oauth = new Google\Service\Oauth2($client);

    $userinfo = $oauth->userinfo->get();

    $email = $userinfo->email;
    $nom = $userinfo->givenName;
    $cognom = $userinfo->familyName;
    $usuari = explode('@', $email)[0];

    $result = iniciSessioOAuth($usuari, $email);
    if ($result == false) {
        insertarNouUsuariOAuth($usuari, $email, $nom, $cognom);
    }

    $_SESSION["loginId"] = $result["id_usuari"];
    $_SESSION["loginUsuari"] = $result["usuari"];
    $_SESSION["loginCorreu"] = $result["correu"];
    $_SESSION["loginNom"] = isset($result["nom"]) && $result["nom"] ? $result["nom"] : "";
    $_SESSION["loginCognom"] = isset($result["cognoms"]) && $result["cognoms"] ? $result["cognoms"] : "";
    $_SESSION["loginImage"] = $result["imatge"];
    $_SESSION["loginAdministrador"] = $result["administrador"];
    $_SESSION["loginAutentificacio"] = $result["autentificacio"];

    header('Location: ../../index.php');
?>