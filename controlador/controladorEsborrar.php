<?php
    //Alba Matamoros Morales
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }    
    //Array d'errors.
    $errors = [];
    //Comprovar l'exsistencia d'un usuari.
    $exsist = false;
    //Comprovat si tot a estat ok.
    $correcte = "";
    //Comprovar si el personatge es seu.
    $creat = false;
    require_once "../model/modelPersonatges.php";
    require_once "../model/modelUsuaris.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $accion = ($_POST["action"]);

        try {
            if ($accion == "Esborrar"){
                $nom = htmlspecialchars($_POST["nom"]);
                $usuariId = htmlspecialchars($_SESSION["loginId"]);

                //Control d'errors.
                if (empty($nom)) $errors[] = "➤ Has de proporcionar un personatge per modificar-lo.";
            
                //COMPROVACIÓ A MODEL, EXSISTEIX PERSONATGE + USUARI.
                if (empty($errors)){
                    $existe = selectComprovarNom($nom);
                    if ($existe == false){
                        $errors[] = "➤ No existeix cap personatge amb aquest Nom.";
                    } else {
                        $creat = selectComprovarUsuariId($nom, $usuariId);
                        if ($creat == false){
                            //Si no es propi no es pot modificar.
                            $errors[] = "➤ No pots esborrar un personatge que no es teu.";
                        } else { esborrar($nom); }
                        if (empty($errors)) { 
                            $correcte = "Article esborrat correctament!";
                            include "../vista/vistaEsborrar.php";
                        } else { include "../vista/vistaEsborrar.php"; }
                    } 
                    if (!empty($errors)) { include "../vista/vistaEsborrar.php"; }
                } else { include "../vista/vistaEsborrar.php"; }
            } else { 
                $errors[] = "No es pot completar aquesta acció.";
                include "../vista/vistaEsborrar.php"; }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET['id_personatge'])) {
            $idPersonatge = $_GET['id_personatge'];
        
            esborrarPerId($idPersonatge);
        
            header("Location: ../index.php?pagina=1");
        } else if (isset($_GET['id_usuari'])) {
            $idUsuari = $_GET['id_usuari'];
        
            esborrarUsuariPerId($idUsuari);
        
            header("Location: ../vista/vistaAdministrarUsuaris.php");
        } else {
            header("Location: ../index.php?pagina=1");
        }
    }
?>