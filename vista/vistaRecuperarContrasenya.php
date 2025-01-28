<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estils/perfil.css">
    <link rel="stylesheet" href="../estils/general.css">
    <link rel="stylesheet" href="../estils/errors.css">
    <title>Recuperar Contraseña</title>
</head>
<body>
    <?php
        //Verificar si la sessió no està activa. (Comprovació perquè no s'intenti accedir mitjançant ruta).
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        require_once "../controlador/controladorAdministrarPerfil.php";
        require_once "../controlador/controladorErrors.php";

        $errors = isset($errors) ? $errors : [];
        $correcte = isset($correcte) ? $correcte : null;
    ?>
    <!-- HEADER -->
    <nav>
        <!-- INICI y GESTIÓ D'ARTICLES -->
        <div class="left">
            <a href="../index.php">INICI</a>
        </div>

        <!-- PERFIL -->
        <div class="perfil">
            <a> 
                <img src="../vista/imatges/imatgesUsers/defaultUser.jpg" class="user-avatar">
                PERFIL 
            </a>
            <div class="dropdown-content">
                <a href="../vista/vistaLogin.php">Iniciar sessió</a>
                <a href="../vista/vistaRegistrarse.php">Registrar-se</a>
            </div>
        </div>
    </nav>

    <div class="content">
        <!-- BODY -->
        <div class="container-general-perfil">
            <form action="../controlador/controladorAdministrarPerfil.php" method="post">
                <h2>Heu oblidat la contrasenya?</h2>
                <div class="info-container">
                                <p>Si us plau, introdueix l'adreça de correu electrònic que vas utilitzar per a registrar-te.</p>
                    <p>T'enviarem un mail amb l'enllaç per començar amb el procés de recuperació.</p>
                </div>
                <label for="email">Introdueix el teu correu electrònic:</label>
                <input type="email" id="email" name="email" required>
                <input type="submit" name="action" value="Restablir Contrasenya">

                <!-- CONTROL D'ERRORS -->
                <?php mostrarMissatge($errors, $correcte) ?>
            </form>
        </div>
    </div>
</body>
</html>