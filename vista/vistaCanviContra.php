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
        if (!isset($_SESSION['loginId']) && !isset($_GET['token']) && !isset($_SESSION['token'])) {
            header("Location: ../index.php");
        }
        require_once "../controlador/controladorErrors.php";

        $errors = isset($errors) ? $errors : [];
        $correcte = isset($correcte) ? $correcte : null;
    ?>
    <nav>
        <!------------------------>
        <!-- BARRA DE NAVEGACIÓ -->
        <!------------------------>

        <!-- INICI y GESTIÓ D'ARTICLES -->
        <div class="left">
        <a href="../index.php">INICI</a>
            <!-- Botó activat amb l'inici de sessió fet "GESTIÓ DE PERSONATGES" -->
            <?php if(isset($_SESSION["loginId"])): ?>
                <a href="../vista/vistaMenu.php">GESTIÓ DE PERSONATGES</a>
                <a href="../vista/vistaApiPersonatges.php">GRAND LINE</a>
            <?php endif; ?>
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
                    <img src="<?php echo isset($_SESSION['loginImage']) ? $_SESSION['loginImage'] : "..vista/imatges/imatgesUsers/defaultUser.jpg" ; ?>" class="user-avatar">
                    <?php
                        $nomUsuari = $_SESSION["loginUsuari"]; 
                        echo $nomUsuari;
                    ?> 
                </a>
                <div class="dropdown-content">
                    <a href="../vista/vistaPerfil.php">Administrar perfil</a>
                    <a href="../vista/vistaLectorQR.php">Lector QR</a>
                    <?php if (empty($_SESSION["loginAutentificacio"])) : ?>
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
        <?php if (isset($_SESSION['loginId'])): ?>
            <div class="container-general-perfil">
                <h2>Canviar Contrasenya</h2>
                <form action="../controlador/controladorAdministrarPerfil.php" method="POST">

                    <label for="contrasenya_actual">Contrasenya Actual:</label>
                    <input type="password" id="contrasenya_actual" name="contrasenya_actual">

                    <label for="nova_contrasenya">Nova Contrasenya:</label>
                    <input type="password" id="nova_contrasenya" name="nova_contrasenya">

                    <label for="confirmar_contrasenya">Confirmar Contrasenya:</label>
                    <input type="password" id="confirmar_contrasenya" name="confirmar_contrasenya">

                    <input type="submit" name="action" value="Canviar Contrasenya">

                    <!-- CONTROL D'ERRORS -->
                    <?php mostrarMissatge($errors, $correcte) ?>
                </form>
            </div>
        <?php elseif (isset($_GET['token']) || (isset($_SESSION['token']))): ?>
            <div class="container-general-perfil">
                <h2>Canviar Contrasenya</h2>
                <form action="../controlador/controladorAdministrarPerfil.php" method="POST">

                    <label for="nova_contrasenya">Nova Contrasenya:</label>
                    <input type="password" id="nova_contrasenya" name="nova_contrasenya">

                    <label for="confirmar_contrasenya">Confirmar Contrasenya:</label>
                    <input type="password" id="confirmar_contrasenya" name="confirmar_contrasenya">

                    <?php if (isset($_GET['token'])): ?>
                        <input type="hidden" name="token" value="<?php echo isset($_GET['token']) ? $_GET['token'] : ''; ?>">
                    <?php endif; ?>

                    <?php if (isset($_SESSION['token'])): ?>
                        <input type="hidden" name="token" value="<?php echo isset($_SESSION['token']) ? $_SESSION['token'] : ''; ?>">
                    <?php endif; ?>

                    <input type="submit" name="action" value="Restablir">

                    <!-- CONTROL D'ERRORS -->
                    <?php mostrarMissatge($errors, $correcte) ?>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>