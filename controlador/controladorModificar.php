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
    //Guardem les dades del personatge en concret.
    $PersonatgeBD;
    require_once "../model/modelPersonatges.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $accion = ($_POST["action"]);

        try {
            if ($accion == "Modificar"){
                $nom = htmlspecialchars($_POST["nom"]);
                $usuariId = htmlspecialchars($_SESSION["loginId"]);

                //Control d'errors.
                if (empty($nom)) $errors[] = "➤ Has de omplenar el nom per poder buscar el personatge que vols modificar.";

                if (empty($errors)) {
                    //Guardem el resultat del select, si no trova res retornara FALSE.
                    $existe = selectComprovarNom($nom);
                    if ($existe == false){
                        $errors[] = "➤ No existeix cap personatge amb aquest Nom.";
                    } else {
                        $creat = selectComprovarUsuariId($nom, $usuariId);
                        if ($creat == false){
                            $errors[] = "➤ No pots modificar un personatge que no es teu.";
                        } else {
                            
                            $personatgeId = obtenerIdDelPersonatgePerNom($nom);
                            if ($personatgeId) {
                                header("Location: ../vista/vistaModificarDades.php?id_personatge=$personatgeId");
                            } else { $errors[] = "➤No es pot obtenir l'Id del personatge."; }
                        }
                    }
                    if (!empty($errors)){ include "../vista/vistaModificar.php"; }
                } else { include "../vista/vistaModificar.php"; }
            } else { 
                $errors[] = "No es pot completar aquesta acció.";
                include "../vista/vistaModificar.php"; }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>