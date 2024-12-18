<?php
    //Alba Matamoros Morales
    //Array d'errors.
    $errors = [];
    //Comprovar l'exsistencia d'un usuari.
    $exsist = false;
    //Missatge confirmació.
    $correcte = "";
    require_once "../model/modelUsuaris.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $accion = $_POST["action"];

        try {
            if ($accion == "Registrar-se"){

                $nom = htmlspecialchars(($_POST["nom"]));
                $cognoms = htmlspecialchars(($_POST["cognoms"]));
                $usuari = trim(htmlspecialchars($_POST["usuari"]));
                $email = htmlspecialchars(($_POST["email"]));
                $contrasenya = htmlspecialchars(($_POST["contrasenya"]));
                $confirmar_contrasenya = htmlspecialchars(($_POST["confirmar_contrasenya"]));

                //Camps obligatoris.
                if (empty($nom)) { $errors[] = "➤ El camp 'nom' és obligatori"; } 
                if (empty($cognoms)) { $errors[] = "➤ El camp 'cognoms' és obligatori"; }
                if (empty($usuari)) { $errors[] = "➤ El camp 'usuari' és obligatori"; }
 
                //CORREU
                if (empty($email)) { $errors[] = "➤ El camp 'correu' és obligatori"; } 
                elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){ $errors[] = "➤ La contrasenya ha de tenir almenys una minúscula, una majúscula, un número, un caràcter especial i un mínim de 8 caràcters"; }
                
                //CONTRASENYA
                if (empty($contrasenya)) { $errors[] = "➤ El camp 'contrasenya' és obligatori"; }
                //Regex compir contrasenya.
                elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/', $contrasenya)){ $errors[] = "➤ La contrasenya ha de tenir almenys una minúscula, una majúscula, un número, un caràcter especial i un mínim de 8 caràcters."; }
                if (empty($confirmar_contrasenya)) { $errors[] = "➤ El camp 'confirmar contrasenya' és obligatori"; }
                elseif ( $contrasenya != $confirmar_contrasenya) { $errors[] = "➤ Contrasenya i confirmar contrasenya no son iguals"; }
                //Cifrar contrasenya.
                else { $contrasenyaCifrada = password_hash($contrasenya, PASSWORD_DEFAULT); }

                //Si errors es buit ->
                if (empty($errors)) {
                    $existe = comprovarUsuariIEmail($usuari, $email);
                    if ($existe == false){
                        insertarNouUsuari($nom, $cognoms, $usuari, $email, $contrasenyaCifrada);
                        $correcte = "Usuari Registrat correctament!";
                        unset($_POST["nom"]);
                        unset($_POST["cognoms"]);
                        unset($_POST["usuari"]);
                        unset($_POST["email"]);
                        include "../vista/vistaRegistrarse.php"; 
                    } else { $errors[] = "➤ Aquest usuari o email ja exsisteix"; }
                    if (!empty($errors)){ 
                        include "../vista/vistaRegistrarse.php"; 
                    }
                } else { include "../vista/vistaRegistrarse.php"; }
            } else { 
                $errors[] = "➤ No es pot completar aquesta acció.";
                include "../vista/vistaRegistrarse.php"; }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>