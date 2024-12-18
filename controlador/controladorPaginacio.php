<?php
    //Alba Matamoros Morales.    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if(str_contains($_SERVER['SCRIPT_NAME'], '/vista')) {
        require_once '../model/modelPaginacio.php';
        require_once '../model/modelUsuaris.php';
    } else {
        require_once './model/modelPaginacio.php';
    }

    define("PAGINA", 1);
    //guardar els personatges per pagina.
    define("PERSONATGES_PER_PAGINA", isset($_COOKIE["personatgesCookie"]) ? $_COOKIE["personatgesCookie"] : 5);

    //-----------------------------------------
    //PAGINA ACTUAL + CALCUL PAGINES TOTALS.
    //Si es null, la pagina per defecte sera 1.
    $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;


    //PER USUARI
    if (isset($_SESSION['loginId']) && isset($_GET['search']) && $_GET['search'] != "" && !str_contains($_SERVER['SCRIPT_NAME'], '/vista')) {
        $totalPersonatges = cercaCountPersonatgesUsuari($_GET['search'], $_SESSION['loginId']);
    } elseif (isset($_SESSION['loginId']) && !str_contains($_SERVER['SCRIPT_NAME'], '/vista')){
        $totalPersonatges = countPersonatgesPerUsuari($_SESSION['loginId']);
    } else if (isset($_GET['search'])){
        $totalPersonatges = cercaCountPersonatges($_GET['search']);
    } else {
        $totalPersonatges = countPersonatges();
    }
    
    $cerca = isset($_GET['search']) ? $_GET['search'] : "";

    $totalPagines = ceil($totalPersonatges / PERSONATGES_PER_PAGINA);

    // Evitar que la página actual exceda los límites
    if ($paginaActual < 1) {
        $paginaActual = 1;
    } elseif ($paginaActual > $totalPagines) {
        $paginaActual = $totalPagines;
    }

    //-----------------------------------------

    //--------------------------
    //--- FUNCIONS PAGINACIÓ ---
    //--------------------------

    //-----------------------------------------
    //-------------- USUARI -------------------

    //LINKS: PAGINACIO PER USUARI.
    //CREAR ELS LINKS DE LA PAGINACIÓ PER USUARI.
    function retornarLinksPerUsuari(){
        global $paginaActual;
        global $totalPagines;
        global $cerca;

        $mostrarPaginacio = "";

        //PAGINACIO BOTONS.
        //Boto Anterior.
        if ($paginaActual > 1){ $mostrarPaginacio .= sprintf("<a class='activat' href='%s?search=%s&pagina=%d'>Anterior</a>",$_SERVER['PHP_SELF'], $cerca, $paginaActual - 1); 
        } else { $mostrarPaginacio .= "<a class='desactivat'>Anterior</a>"; }

        //Botons intermitjos, 1,2,3...
        for ($i = 1; $i <= $totalPagines; $i++ ){
            if ($i == $paginaActual){
                $mostrarPaginacio .= sprintf("<a class='desactivado'>%d</a>", $i);
            } else { $mostrarPaginacio .= sprintf("<a class='activat' href='%s?search=%s&pagina=%d'>%d</a>",$_SERVER['PHP_SELF'], $cerca, $i, $i); }
        }

        //Boto Següent.
        if ($paginaActual < $totalPagines){ $mostrarPaginacio .= sprintf("<a class='activat' href='%s?search=%s&pagina=%d'>Següent</a>",$_SERVER['PHP_SELF'], $cerca, $paginaActual + 1); }
        else { $mostrarPaginacio .= "<a class='desactivat'>Següent</a>"; }

        return $mostrarPaginacio;
    }

    //MOSTRAR PERSONATGES PER USUARI.
    //PAGINACIO DELS PERSONATGES PROPIS D'UN USUARI.
    function paginacioPerUsuari(){
        global $paginaActual;

        $mostrarPersonatges = "";

        if ($paginaActual < 1) $paginaActual = 1;

        if (!empty($_GET['search'])) {
            $cerca = trim($_GET['search']);
            if ($_COOKIE['ordenacioCookie'] == "ASC") {
                //ASC
                $personatges = cercaPersonatgesUsuari($cerca, $_SESSION['loginId'], $paginaActual, PERSONATGES_PER_PAGINA);
            } else {
                //DESC
                $personatges = cercaPersonatgesUsuariDESC($cerca, $_SESSION['loginId'], $paginaActual, PERSONATGES_PER_PAGINA);
            }
        } else {
            if ($_COOKIE['ordenacioCookie'] == "ASC") {
                //ASC
                $personatges = consultarPerUsuariPaginacio($_SESSION['loginId'], $paginaActual, PERSONATGES_PER_PAGINA);
            } else {
                $personatges = consultarPerUsuariPaginacioDESC($_SESSION['loginId'], $paginaActual, PERSONATGES_PER_PAGINA);
            }
        }

        if (!empty($personatges)) {
            foreach ($personatges as $personatge){
                $mostrarPersonatges .= sprintf(
                    '<div class="personatge-box">
                        <h2 class="personatge-nom">%s</h2>
                        <p class="personatge-cos">%s</p>
                        <div class="personatge-botons">
                            <a class="eliminar-btn" href="#" onclick="confirmarEsborrar(%s)">🗑️</a>
                            <a class="modificar-btn" href="vista/vistaModificarDades.php?id_personatge=%s">✏️</a>
                        </div>
                    </div>
                ', $personatge['nom'], $personatge['cos'], $personatge['id_personatge'], $personatge['id_personatge']);
            }
        } else {
            $mostrarPersonatges = '<p>No hi ha personatges disponibles.</p>';
        }

        return $mostrarPersonatges;
    }
    //-----------------------------------------
    //-------------- GLOBAL -------------------

    //LINKS: PAGINACIO GLOBAL.
    //CREAR ELS LINKS DE LA PAGINACIÓ GLOBAL.
    function retornarLinksGlobal(){
        global $paginaActual;
        global $totalPagines;
        global $cerca;

        $mostrarPaginacio = "";

        //PAGINACIO BOTONS.
        //Boto Anterior.
        if ($paginaActual > 1){ $mostrarPaginacio .= sprintf("<a class='activat' href='%s?search=%s&pagina=%d'>Anterior</a>",$_SERVER['PHP_SELF'], $cerca, $paginaActual - 1); }
        else { $mostrarPaginacio .= "<a class='desactivat'>Anterior</a>"; }

        //Botons intermitjos, 1,2,3...
        for ($i = 1; $i <= $totalPagines; $i++ ){
            if ($i == $paginaActual){
                $mostrarPaginacio .= sprintf("<a class='desactivado'>%d</a>", $i);
            } else { $mostrarPaginacio .= sprintf("<a class='activat' href='%s?search=%s&pagina=%d'>%d</a>",$_SERVER['PHP_SELF'], $cerca, $i, $i); }
        }

        //Boto Següent.
        if ($paginaActual < $totalPagines){ $mostrarPaginacio .= sprintf("<a class='activat' href='%s?search=%s&pagina=%d'>Següent</a>",$_SERVER['PHP_SELF'], $cerca, $paginaActual + 1); }
        else { $mostrarPaginacio .= "<a class='desactivat'>Següent</a>"; }

        return $mostrarPaginacio;
    }

    //MOSTRAR PERSONATGES GLOBAL.
    //PAGINACIO DELS PERSONATGES GLOBAL.
    function paginacioGlobal(){
        global $paginaActual;
        
        $mostrarPersonatges = "";

        if ($paginaActual < 1) $paginaActual = 1;

        if (!empty($_GET['search'])) {
            $cerca = trim($_GET['search']);
            if ($_COOKIE['ordenacioCookie'] == "ASC") {
                //ASC
                $personatges = cercaPersonatgesGlobal($cerca, $paginaActual, PERSONATGES_PER_PAGINA);
            } else {
                //DESC 
                $personatges = cercaPersonatgesGlobalDESC($cerca, $paginaActual, PERSONATGES_PER_PAGINA);
            }          
        } else {
            if ($_COOKIE['ordenacioCookie'] == "ASC") {
                //ASC
                $personatges = consultarPaginacio($paginaActual, PERSONATGES_PER_PAGINA);
            } else {
                //DESC
                $personatges = consultarPaginacioDESC($paginaActual, PERSONATGES_PER_PAGINA); 
            } 
        }

        if (!empty($personatges)) {
            foreach ($personatges as $personatge){
                $mostrarPersonatges .= sprintf(
                    '<div class="personatge-box">
                        <h2 class="personatge-nom">%s</h2>
                        <p class="personatge-cos">%s</p>
                    </div>
                ', $personatge['nom'], $personatge['cos']);
            }
        } else {
            $mostrarPersonatges = '<p>No hi ha personatges disponibles.</p>';
        }

        return $mostrarPersonatges;
    }

    //-----------------------------------------------------
    //-------------- ADMINISTRAR USUARIS -------------------

    function mostrarUsuaris() {
        $mostrarUsuaris = "";
    
        $usuaris = mostrarTotsElsUsuaris($_SESSION['loginId']); 
    
        if (!empty($usuaris)) {
            foreach ($usuaris as $usuari) {
                $mostrarUsuaris .= "<tr>
                                        <td>
                                            <img src='" . (empty($usuari['imatge']) ? "../vista/imatges/imatgesUsers/defaultUser.jpg" : $usuari['imatge']) . "' width='50'>
                                        </td>
                                        <td>{$usuari['usuari']}</td>
                                        <td>{$usuari['nom']}</td>
                                        <td>{$usuari['cognoms']}</td>
                                        <td>{$usuari['correu']}</td>
                                        <td>
                                            <a href='#' onclick='confirmarEsborrarUsuari({$usuari["id_usuari"]})'>Eliminar</a>
                                        </td>
                                    </tr>";
            }
        } else {
            $mostrarUsuaris = '<tr><td colspan="5">No hi ha usuaris disponibles.</td></tr>';
        }
    
        return $mostrarUsuaris;
    }
    
?>