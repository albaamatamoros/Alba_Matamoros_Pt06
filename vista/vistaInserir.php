<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Alba Matamoros Morales -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estils/menu.css">
    <link rel="stylesheet" href="../estils/general.css">
    <link rel="stylesheet" href="../estils/errors.css">
    <title>Inserir Personatge</title>
</head>
<body>
    <?php
        //Verificar si la sessió no està activa. (Comprovació perquè no s'intenti accedir mitjançant ruta).
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION["loginId"])) { header("Location: ../vista/errors/vistaError403.php" );}
        require_once "../controlador/controladorErrors.php";

        $errors = isset($errors) ? $errors : [];
        $correcte = isset($correcte) ? $correcte : null;
    ?>
    <nav>
        <!-- INICI y GESTIÓ D'ARTICLES -->
        <div class="left">
            <a href='../index.php'>INICI</a>
            <a href="../vista/vistaMenu.php">GESTIÓ DE PERSONATGES</a>
            <a href="../vista/vistaApiPersonatges.php">GRAND LINE</a>
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
    <div class="content">
        <!-- INSERIR ARTICLE -->
        <div class="container-accio">
            <h1>INSERIR PERSONATGE</h1>
            
            <form action="../controlador/controladorInsertar.php" method="POST">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value="<?php 
                    echo isset($_GET['nom']) ? htmlspecialchars($_GET['nom']) : (isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '');
                ?>"/>            

                <label for="text">Descripció:</label>

                <input type="text" id="text" name="text" value="<?php 
                    echo isset($_GET['cos']) ? htmlspecialchars($_GET['cos']) : (isset($_POST['text']) ? htmlspecialchars($_POST['text']) : ''); 
                ?>" />
                
                <!-- CONTROL D'ERRORS -->
                <?php mostrarMissatge($errors, $correcte) ?>

                <!-- INSERIR -->
                <div class="button-group">
                    <input type="submit" name="action" value="Inserir" class="boto"/>
                    <button onclick="location.href='../vista/vistaMenu.php'" type="button" class="boto">Tornar</button> 
                </div>
            </form>
        </div>        
    </div>
</body>
</html>
