<?php
    //Alba Matamoros Morales
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    //------------ Variables control d'errors ------------
    //comprovacions, missatges i variables de control.
    $errors = [];
    //comprovar si la contrasenya es correcta.
    $correct = false;
    //existeix l'usuari.
    $exsist = false;
    
    //----------------- reCaptcha -----------------
    //Clau secreta reCaptcha.
    $clauSecretaRecaptcha = "6LeA3owqAAAAAAgYe7JC6GOVbaR46dHA0gOa2jeO";

    require_once "../model/modelUsuaris.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $accion = ($_POST["action"]);
        try {
            if ($accion == "Iniciar sessió"){
                if (!isset($_SESSION['loginRecaptcha'])) {
                    $_SESSION['loginRecaptcha'] = 0;
                }

                $usuari = htmlspecialchars(($_POST["usuari"]));
                $contrasenya = htmlspecialchars(($_POST["contrasenya"]));
                $recaptchaResponse = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : null;
                $remember = isset($_POST["recorda"]) ? true : false;
                
                //Comprovar dades.
                if (empty($usuari)) { $errors[] = "➤ No pots iniciar sessió amb un usuari buit."; } 
                if (empty($contrasenya)) { $errors[] = "➤ Et cal una contrasenya per iniciar sessió.";}

                //----------------- Recaptcha -----------------

                // Si los intentos son >=3, validar el reCAPTCHA
                if ($_SESSION['loginRecaptcha'] >= 3) {
                    // Realiza la petición a la API de reCAPTCHA
                    $recaptchaVerify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$clauSecretaRecaptcha&response=$recaptchaResponse");
                    $recaptchaResult = json_decode($recaptchaVerify, true);

                    if (!$recaptchaResult["success"]) {
                        $errors[] = "➤ Error amb el reCAPTCHA. Torna-ho a intentar.";
                    }
                }
                
                if (empty($errors)) {
                    //COMPROVAR USUARI I CONTRASENYA.
                    $existe = comprovarExistensiaDUsuari($usuari);
                    if ($existe == false) {
                        $errors[] = "➤ No existeix aquest usuari";
                    } else { 
                        $correct = password_verify($contrasenya, $existe['contrasenya']);
                        if (!$correct) {
                            $errors[] = "➤ La contrasenya no es correcta";
                            //Incrementem els intents de reCAPTCHA.
                            $_SESSION['loginRecaptcha']++;
                        } else {
                            //Posem a 0 els intents de reCAPTCHA.
                            $_SESSION['loginRecaptcha'] = 0;

                            if ($remember) {
                                //Crear cookie amb el nom d'usuari.
                                setcookie("usuariNom", $usuari, time() + 60 * 60 * 24 * 30, "/");
                            }

                            //Iniciar sessió.
                            $result = iniciSessio($usuari);

                            //Guardar dades de l'usuari a la sessió.
                            $_SESSION["loginId"] = $result["id_usuari"];
                            $_SESSION["loginUsuari"] = $result["usuari"];
                            $_SESSION["loginCorreu"] = $result["correu"];
                            $_SESSION["loginNom"] = $result["nom"];
                            $_SESSION["loginCognom"] = $result["cognoms"];
                            $_SESSION["loginImage"] = $result["imatge"];
                            $_SESSION["loginAdministrador"] = $result["administrador"];
                            $_SESSION["loginAutentificacio"] = $result["autentificacio"];
                            header("Location: ../index.php");
                        }
                    }
                    if (!empty($errors)){ include "../vista/vistaLogin.php"; }
                } else { include "../vista/vistaLogin.php"; }
            } else { 
                $errors[] = "No es pot completar aquesta acció.";
                include "../vista/vistaLogin.php"; }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>