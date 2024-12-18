<?php
    require_once __DIR__ . '/../../env.php';
    require "../lib/OAuth/vendor/autoload.php";

    $client = new Google\Client;

    $client->setClientId(ID_GOOGLE_LOCALHOST);
    $client->setClientSecret(SECRET_GOOGLE_LOCALHOST);
    $client->setRedirectUri(URL_GOOGLE_LOCALHOST);

    $client->addScope("email");
    $client->addScope("profile");

    $url = $client->createAuthUrl();
?>