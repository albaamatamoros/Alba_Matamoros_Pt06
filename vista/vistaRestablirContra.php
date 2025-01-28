<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Alba Matamoros Morales -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estils/perfil.css">
    <link rel="stylesheet" href="../estils/general.css">
    <link rel="stylesheet" href="../estils/errors.css">
    <title>Registrar-se</title>
</head>
<body>
    <?php
        //Verificar si la sessió no està activa. (Comprovació perquè no s'intenti accedir mitjançant ruta).
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['correcte']) && !isset($_SESSION['caducat'])) {
            header("Location: ../index.php");
        } elseif (isset($_SESSION['loginId'])) {
            header("Location: ../index.php");
        }
        if (isset($_SESSION['token'])) {
            unset($_SESSION['token']);
        }
    ?>
    <nav>
        <!------------------------>
        <!-- BARRA DE NAVEGACIÓ -->
        <!------------------------>

        <!-- INICI y GESTIÓ D'ARTICLES -->
        <div class="left">
        <a href="index.php">INICI</a>
            <!-- Botó activat amb l'inici de sessió fet "GESTIÓ DE PERSONATGES" -->
            <?php if(isset($_SESSION["loginId"])) {
                echo ' <a href="../vista/vistaMenu.php">GESTIÓ DE PERSONATGES</a> ';
            } ?>
            <?php if(isset($_SESSION["loginId"])) {
                echo ' <a href="../vista/vistaApiPersonatges.php">GRAND LINE</a> ';
            } ?>
        </div>

        <!------------>
        <!-- PERFIL -->
        <!------------>
        <div class="perfil">
            <!-- Botons de perfil -->
            <?php if (!isset($_SESSION['loginId'])): ?>
                <a>
                    <img src="../vista/imatges/imatgesUsers/defaultUser.jpg" class="user-avatar">
                    PERFIL
                </a>
                <div class="dropdown-content">
                    <a href="../vista/vistaLogin.php">Iniciar sessió</a>
                    <a href="../vista/vistaRegistrarse.php">Registrar-se</a>
            <?php else: ?>
                <a>
                    <img src="<?php echo isset($_SESSION['loginImage']) ? substr($_SESSION['loginImage'], 1) : "vista/imatges/imatgesUsers/defaultUser.jpg" ; ?>" class="user-avatar">
                    <?php
                        $nomUsuari = $_SESSION["loginUsuari"]; 
                        echo $nomUsuari;
                    ?> 
                </a>
                <div class="dropdown-content">
                    <a href="../vista/vistaPerfil.php">Administrar perfil</a>
                    <?php if (!isset($_SESSION["loginAutentificacio"])): ?>
                        <a href="../vista/vistaCanviContra.php">Canviar contrasenya</a>
                    <?php endif; ?>
                    <?php if ($_SESSION["loginAdministrador"] == 1): ?>
                        <a href="../vista/vistaAdministrarUsuaris.php">Administrar usuaris</a>
                    <?php endif; ?>
                    <a href="../controlador/controladorTancarSessio.php">Tancar sessió</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="content">
        <!-- BODY -->
        <?php if (isset($_SESSION['correcte'])): ?>
            <div class="container-info">
                <h2>CONTRASENYA MODIFICADA</h2>
                <p>La contrasenya s'ha modificat correctament.</p>
                <div>
                    <button class="boto" onclick="location.href='../controlador/controladorTancarSessio.php'" type="button">Tornar</button> 
                </div>
            </div>
        <?php elseif ((isset($_SESSION['caducat']))): ?>
            <div class="container-info">
                <h2>L'ENLLAÇ A EXPIRAT</h2>
                <p>Si us plau, torna a sol·licitar el canvi de contrasenya si vols continuar amb l'operació "canvi de contrasenya".</p>
                <div>
                    <button class="boto" onclick="location.href='../controlador/controladorTancarSessio.php'" type="button">Tornar</button> 
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>