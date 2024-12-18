<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Alba Matamoros Morales -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estils/estilPerfil.css">
    <link rel="stylesheet" href="../estils/estilBarra.css">
    <link rel="stylesheet" href="../estils/estilError.css">
    <title>Perfil</title>
</head>
<body>
    <?php //Verificar si la sessió no està activa. (Comprovació perquè no s'intenti accedir mitjançant ruta).
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION["loginId"])) { header("Location: ../vista/errors/vistaError403.php" );}
        require_once "../controlador/controladorAdministrarPerfil.php";
        require_once "../controlador/controladorErrors.php";

        $errors = isset($errors) ? $errors : [];
        $correcte = isset($correcte) ? $correcte : null;
    ?>
    <div class="content">
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
                    <?php if (!isset($_SESSION["loginAutentificacio"])): ?>
                        <a href="../vista/vistaCanviContra.php">Canviar contrasenya</a>
                    <?php endif; ?>
                    <?php if ($_SESSION["loginAdministrador"] == 1): ?>
                        <a href="../vista/vistaAdministrarUsuaris.php">Administrar usuaris</a>
                    <?php endif; ?>
                    <a href="../controlador/controladorTancarSessio.php">Tancar sessió</a>
                </div>
            </div>
        </nav>

        <div class="login-container">
            <h2>Administrar perfil</h2>
            <form action="../controlador/controladorAdministrarPerfil.php" method="POST" enctype="multipart/form-data">
                <div class="login-container-user">
                    <img src="<?php echo isset($_SESSION['loginImage']) ? $_SESSION['loginImage'] : "../vista/imatges/imatgesUsers/defaultUser.jpg" ; ?>" class="user-avatar2">
                </div>

                <label for="arxiu">Selecciona un arxiu:</label>
                <input type="file" name="arxiu" id="arxiu">

                <?php if (($_SESSION["loginAutentificacio"]) == ""): ?>
                    <label for="username">Nombre de Usuario</label>
                    <input type="text" id="username" name="username" value="<?php echo isset($_SESSION["loginUsuari"]) ? $_SESSION["loginUsuari"] : ''; ?>">
                <?php else: ?>
                    <label for="username">Nombre de Usuario</label>
                    <input type="hidden" id="username" name="username" value="<?php echo isset($_SESSION["loginUsuari"]) ? $_SESSION["loginUsuari"] : ''; ?>">
                    <input type="text" id="user" name="user" value="<?php echo isset($_SESSION["loginUsuari"]) ? $_SESSION["loginUsuari"] : ''; ?>" readonly disabled>
                <?php endif; ?>

                <?php if (isset($_SESSION["loginNom"]) && $_SESSION["loginNom"] != ""): ?>
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" value="<?php echo isset($_SESSION["loginNom"]) ? $_SESSION["loginNom"] : ''; ?>" readonly disabled>
                    <?php endif; ?>

                <?php if (isset($_SESSION["loginCognom"]) && $_SESSION["loginCognom"] != ""): ?>
                    <label for="cognom">Cognoms</label>
                    <input type="text" id="cognom" name="cognom" value="<?php echo isset($_SESSION["loginCognom"]) ? $_SESSION["loginCognom"] : ''; ?>" readonly disabled>
                <?php endif; ?>

                <?php if (isset($_SESSION["loginCorreu"]) && $_SESSION["loginCorreu"] != ""): ?>
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" value="<?php echo isset($_SESSION["loginCorreu"]) ? $_SESSION["loginCorreu"] : ''; ?>" readonly disabled>
                <?php endif; ?>
                
                <!-- CONTROL D'ERRORS -->
                <?php mostrarMissatge($errors, $correcte) ?>

                <input name="action" type="submit" value="Guardar canvis">
            </form>
        </div>
    </div>
</body>
</html>