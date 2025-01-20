<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Alba Matamoros Morales -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estils/estilPersonatges.css">
    <link rel="stylesheet" href="../estils/estilBarra.css">
    <link rel="stylesheet" href="../estils/estilError.css">
    <title>Modificar Personatge</title>
</head>
    <?php
        //Verificar si la sessió no està activa. (Comprovació perquè no s'intenti accedir mitjançant ruta).
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION["loginId"])) { header("Location: ../vista/errors/vistaError403.php" );}
        require_once "../controlador/controladorModificarDades.php";
        require_once "../controlador/controladorErrors.php";

        $errors = isset($errors) ? $errors : [];
        $correcte = isset($correcte) ? $correcte : null;
    ?>
    <body>
        <nav>
            <!-- INICI y GESTIÓ D'ARTICLES -->
            <div class="left">
                <a href='../index.php'>INICI</a>
                <a href="../vista/vistaMenu.php">GESTIÓ DE PERSONATGES</a>
            </div>

            <!-- PERFIL -->
            <div class="perfil">
                <a> 
                    <img src="<?php echo isset($_SESSION['loginImage']) ? $_SESSION['loginImage'] : "../vista/imatges/imatgesUsers/defaultUser.jpg" ; ?>" class="user-avatar"><?php 
                        $nomUsuari = $_SESSION["loginUsuari"]; 
                        echo $nomUsuari;
                    ?> 
                </a>
                <div class="dropdown-content">
                    <a href="../vista/vistaPerfil.php">Administrar perfil</a>
                    <?php if (empty($_SESSION["loginAutentificacio"])) : ?>
                        <a href="../vista/vistaCanviContra.php">Canviar contrasenya</a>
                    <?php endif; ?>
                    <?php if ($_SESSION["loginAdministrador"] == 1): ?>
                        <a href="../vista/vistaAdministrarUsuaris.php">Administrar usuaris</a>
                    <?php endif; ?>
                    <a href="../controlador/controladorTancarSessio.php">Tancar sessió</a>
                </div>
            </div>
        </nav>

        <!-- Agafem l'id del personatge per GET, desde index.php o vistaModificar.php -->
        <?php
            if (isset($_GET["id_personatge"])) {
                $personatgeBD = dadesPersonatge($_GET["id_personatge"]);
    
                if (empty($personatgeBD)) {
                    $errors[] = "No s'han trobat dades per a aquest personatge.";
                }
            }
        ?>

        <!-- MODIFICAR PERSONATGE -->
        <div class="button-container">
            <h1>MODIFICAR PERSONATGE</h1>

            <form action="../controlador/controladorModificarDades.php" method="POST">

                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value="<?php echo isset($personatgeBD["nom"]) ? $personatgeBD["nom"] : ''; ?>"/>
                    
                <label for="text">Descripció:</label>
                <input type="text" id="text" name="text" value="<?php echo isset($personatgeBD["cos"]) ? $personatgeBD["cos"] : ''; ?>"/>

                <!-- CONTROL D'ERRORS -->
                <?php mostrarMissatge($errors, $correcte) ?>

                <!-- Amb un input invisible pasem l'id a controlador -->
                <input type="hidden" name="id" value="<?php echo isset($_GET["id_personatge"]) ? $_GET["id_personatge"] : ''; ?>"/>

                <!-- MODIFICAR -->
                <div class="button-group">
                    <input type="submit" name="action" value="Modificar" class="btn"/> <!-- Botón de modificación -->
                    <button onclick="location.href='../vista/vistaMenu.php'" type="button" class="btn">Tornar</button> 
                </div>
            </form>
        </div>
    </body>
</html>
