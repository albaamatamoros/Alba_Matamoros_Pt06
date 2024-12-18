<?php
    // Alba Matamoros Morales
    // Iniciar la sesión si no se ha iniciado previamente
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once "../model/modelUsuaris.php";
    require "../lib/PHPMailer-master/src/PHPMailer.php";
    require "../lib/PHPMailer-master/src/Exception.php";
    require "../lib/PHPMailer-master/src/SMTP.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // Array para almacenar errores
    $errors = [];
    // Variable para comprobar si el usuario existe
    $exsist = false;
    // Mensaje de confirmación
    $correcte = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $accion = ($_POST["action"]);
        try {
            switch ($accion) {
                case "Guardar canvis":

                    //---------------------------
                    //---  MODIFICAR USUARIO  ---
                    //---------------------------

                    //CANVIAR USUARIO:
                    $nomUsuari = trim(htmlspecialchars($_POST["username"]));
                    $usuariId = htmlspecialchars($_SESSION["loginId"]);

                    if (empty($nomUsuari)) {
                        $errors[] = "➤ El camp usuari es obligatori i no es pot deixar buit."; 
                    }

                    if ($_FILES["arxiu"]["name"] == "" && $nomUsuari == $_SESSION["loginUsuari"]) {
                        $errors[] = "➤ No s'ha fet cap canvi.";
                    }

                    //------- MODIFICAR NOM USUARI -------
                    if (empty($errors)) {
                        // Comprobar si el nombre de usuario ya existe
                        $exsist = comprovarNomUsuariExistent($nomUsuari, $_SESSION["loginId"]);
                        if ($exsist != false) {
                            $errors[] = "➤ Ja existeix un usuari amb aquest nom.";
                        } else {
                            // Si no hay errores, modificar el nombre de usuario
                            $_SESSION["loginUsuari"] = $nomUsuari;
                            modificarNomUsuari($nomUsuari, $usuariId);
                            $correcte = "➤ Usuari modificat correctament.";
                        }
                    }

                    //-------- MODIFICAR IMATGE -------
                    if ($_FILES["arxiu"]["name"] != "") {

                        $tipusImatge = $_FILES['arxiu']['type'];
                        if ($tipusImatge != 'image/png' && $tipusImatge != 'image/jpg' && $tipusImatge != 'image/jpeg') { $errors[] = "➤ Tipus d'arxiu no permès. Només es permeten PNG i JPG."; }

                        if (empty($errors)) {
                            // CANVIAR/AFEGIR IMATGE:
                            if ($_FILES['arxiu']['error'] == 0) {
                                // Obtener detalles de la imagen
                                $nomImatge = $_FILES['arxiu']['name'];
                                
                                var_dump($tipusImatge);
                                $directoriTemporalImatge = $_FILES['arxiu']['tmp_name']; 

                                // Carpeta de destino para la imagen
                                $directoriDestiImatge = '../vista/imatges/imatgesUsers/';
                                $nomUnic = uniqid() . "_" . basename($nomImatge);

                                // Mover el archivo al directorio de destino
                                if (move_uploaded_file($directoriTemporalImatge, $directoriDestiImatge . $nomUnic)) {
                                    if (isset($_SESSION["loginImage"])) {
                                        // Eliminar la imagen anterior
                                        unlink($_SESSION["loginImage"]);
                                    }
                                    // Guardar la URL de la imagen
                                    $urlImatge = $directoriDestiImatge . $nomUnic;
                                    modificarImatgePerfilUsuari($urlImatge, $usuariId);
                                    $_SESSION["loginImage"] = $urlImatge;
                                    $correcte = "➤ Usuari modificat correctament.";
                                } else {
                                    $errors[] = "➤ Error al pujar la imatge.";
                                }
                            } else {
                                $errors[] = "➤ Error al pujar la imatge.";
                            }
                        }
                    }
                    
                    include "../vista/vistaPerfil.php"; 
                    break;
                case "Canviar Contrasenya":
                    //-----------------------------
                    //---  CANVIAR CONTRASENYA  ---
                    //-----------------------------

                    //CANVIAR CONTRASENYA:
                    $contrasenyaActual = (htmlspecialchars($_POST["contrasenya_actual"]));
                    $novaContrasenya = (htmlspecialchars($_POST["nova_contrasenya"]));
                    $confirmarContrasenya = (htmlspecialchars($_POST["confirmar_contrasenya"]));

                    //CONTROL D'ERRORS
                    //Obligatoris.
                    if (empty($contrasenyaActual)) { $errors[] = "➤ El camp 'contrasenya_actual' és obligatori."; } 
                    if (empty($novaContrasenya)) { $errors[] = "➤ El camp 'nova_contrasenya' és obligatori."; }
                    if (empty($confirmarContrasenya)) { $errors[] = "➤ El camp 'confirmar_contrasenya' és obligatori."; }

                    //Regex complir contrasenya.
                    //Comprovar que siguin iguals o que no sigui la mateixa.
                    elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/', $novaContrasenya)){ $errors[] = "El format de la contrasenya no és correcte."; }
                    elseif ( $novaContrasenya != $confirmarContrasenya) { $errors[] = "➤ Nova contrasenya i confirmar contrasenya no son iguals."; }
                    elseif ( $contrasenyaActual == $novaContrasenya) { $errors[] = "➤ Aquesta ja es la teva actual contrasenya."; }

                    //Si errors es buit ->
                    if (empty($errors)) {
                        //Agafem l'i usuari.
                        $usuariId = $_SESSION["loginId"];
                        //COMPROVEM CONTRASENYA I USUARI I MODIFIQUEM.
                        $existe = comprovarContrasenyaId($usuariId);
                        if ($existe == false) {
                            $errors[] = "➤ No existeix aquest usuari.";
                        } else { 
                            $correct = password_verify($contrasenyaActual, $existe['contrasenya']); 
                            if ($correct == false){
                                $errors[] = "➤ La contrasenya Actual no es correcta.";
                            } else {
                                //Si exsisteix l'usuari i la contrasenya es correcte, modifiquem.
                                //Cifrar contrasenya.
                                $contrasenyaCifrada = password_hash($novaContrasenya, PASSWORD_DEFAULT);
                                modificarContrasenya($contrasenyaCifrada, $usuariId);
                                $correcte = "➤ Contrasenya canviada correctament.";
                                include "../vista/vistaCanviContra.php";
                            }
                        }
                        if (!empty($errors)){ 
                            include "../vista/vistaCanviContra.php"; 
                        }
                    } else { include "../vista/vistaCanviContra.php"; }

                    break;
                case "Restablir Contrasenya":

                    //-------------------------------
                    //---  RESTABLIR CONTRASENYA  ---
                    //-------------------------------

                    //RESTABLIR CONTRASENYA:
                    $email = htmlspecialchars($_POST["email"]);

                    //CONTROL D'ERRORS
                    if (empty($email)) { 
                        $errors[] = "➤ El camp 'email' és obligatori."; 
                    }
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
                        $errors[] = "➤ El format de l'email no és correcte."; 
                    }

                    //Si errors es buit ->
                    if (empty($errors)) {
                        //Comprobar si existeix l'email.
                        $existe = comprovarEmail($email);
                        if ($existe == false) {
                            $errors[] = "➤ No existeix aquest usuari.";
                        } elseif ($existe['autentificacio'] != ""){
                            $errors[] = "➤ Aquest usuari ha iniciat sessió amb una plataforma externa, no es pot canviar la contrasenya.";
                        } else {
                            $_SESSION['emailToken'] = $email;
                            // Generar un token único
                            $token = bin2hex(random_bytes(50)); // Crear un token aleatori de 50 caracteres
                            $expires = time() + 3600; // El token expira en 1 hora (3600 segons)

                            guardarToken($email, $token, $expires);

                            $resetLink = "http://albamatamoros.cat/vista/vistaCanviContra.php?token=" . $token; // Enlace con el token
                            
                            $text = "
                            <!DOCTYPE html>
                            <html lang='ca'>
                            <head>
                                <meta charset='UTF-8'>
                                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                                <title>Restabliment de contrasenya</title>
                            </head>
                            <body style='font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 0; background-color: #f9f9f9; color: #333;'>
                                <div style='max-width: 600px; margin: 20px auto; background: #ffffff; border: 1px solid #ddd; border-radius: 8px; padding: 20px;'>
                                    <h2 style='color: #444; text-align: center;'>Restabliment de la contrasenya</h2>
                                    <p>Benvolgut/da,</p>
                                    <p>Hem rebut una sol·licitud per restablir la contrasenya del teu compte. Si us plau, fes clic al botó següent per a restablir-la:</p>
                                    <div style='text-align: center; margin: 20px 0;'>
                                        <a href='$resetLink' style='background-color: #007bff; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 4px; font-size: 16px;'>Restablir contrasenya</a>
                                    </div>
                                    <p>O també pots copiar i enganxar aquest enllaç al teu navegador:</p>
                                    <p><a href='$resetLink' style='color: #007bff;'>$resetLink</a></p>
                                    <hr style='border: none; border-top: 1px solid #eee; margin: 20px 0;'>
                                    <p style='font-size: 12px; color: #999;'>Si no has sol·licitat aquest canvi, ignora aquest correu electrònic. Per a qualsevol dubte o incidència, contacta amb nosaltres.</p>
                                    <p style='text-align: center; font-size: 12px; color: #bbb;'>L'equip d'Alba Matamoros</p>
                                </div>
                            </body>
                            </html>
                            ";

                            // Configuración PHPMailer.
                            $mail = new PHPMailer(true);

                            try {
                                $mail->isSMTP();
                                $mail->Host       = 'smtp.gmail.com';
                                $mail->SMTPAuth   = true;                                
                                $mail->Username   = 'a.matamoros@sapalomera.cat';            
                                $mail->Password   = 'kcdm ajyc vqqj eawf';             
                                $mail->SMTPSecure = 'tls';
                                $mail->Port       = 587;
                                
                                $mail->setFrom('a.matamoros@sapalomera.cat', 'albamatamoros.cat');
                                $mail->addAddress($email);
                                
                                $mail->isHTML(true);
                                $mail->Subject = 'Restablir Contrasenya';
                                $mail->Body = $text;

                                $mail->send();

                                $correcte = "➤ S'ha enviat un correu electrònic amb les instruccions per a restablir la teva contrasenya.";

                            } catch (Exception $e) {
                                $errors[] = "➤ Error en enviar el correu: " . $mail->ErrorInfo;
                            }
                        }
                    }

                    include "../vista/vistaRecuperarContrasenya.php";
                    
                    break;
                case 'Restablir':
                    if (isset($_POST['token'])) {
                        $token = $_POST['token'];
                        $_SESSION['token'] = $token;

                        $novaContrasenya = (htmlspecialchars($_POST["nova_contrasenya"]));
                        $confirmarContrasenya = (htmlspecialchars($_POST["confirmar_contrasenya"]));

                        if (empty($novaContrasenya)) { $errors[] = "➤ El camp 'nova_contrasenya' és obligatori."; }
                        if (empty($confirmarContrasenya)) { $errors[] = "➤ El camp 'confirmar_contrasenya' és obligatori."; }

                        $usuariIdToken = comprovarToken($token);
                        if ($usuariIdToken == false) {
                            $errors[] = "➤ L'enllaç a expirat.";
                            $_SESSION['caducat'] = 1;
                            header("Location: ../vista/vistaRestablirContra.php");
                        }

                        $correct = password_verify($novaContrasenya, $usuariIdToken['contrasenya']);
                        var_dump($correct);
                        var_dump($novaContrasenya);
                        var_dump($usuariIdToken['contrasenya']);
                        if ($correct == true) {
                            $errors[] = "➤ La contrasenya nova no pot ser igual que l'actual.";
                        }

                        //Regex complir contrasenya.
                        //Comprovar que siguin iguals o que no sigui la mateixa.
                        elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/', $novaContrasenya)){ $errors[] = "El format de la contrasenya no és correcte."; }
                        elseif ( $novaContrasenya != $confirmarContrasenya) { $errors[] = "➤ Nova contrasenya i confirmar contrasenya no son iguals."; }

                        if (empty($errors)) {
                            //Cifrar contrasenya.
                            $contrasenyaCifrada = password_hash($novaContrasenya, PASSWORD_DEFAULT);
                            modificarContrasenya($contrasenyaCifrada, $usuariIdToken['id_usuari']);
                            $_SESSION['correcte'] = 1;
                            header("Location: ../vista/vistaRestablirContra.php");
                        }
                    } else {
                        $errors[] = "➤ No s'ha pogut restablir la contrasenya.";
                    }

                    include "../vista/vistaCanviContra.php";
                    break;
                default:
                    //SI NO AGAFA CAP DADA:
                    $errors[] = "No es pot completar aquesta acció.";
                    include "../index.php";
                    break;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>
