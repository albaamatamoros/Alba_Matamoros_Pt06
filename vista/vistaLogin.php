<?php //Verificar si la sessió no està activa. (Comprovació perquè no s'intenti accedir mitjançant ruta).
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION["loginId"])) { header("Location: ../vista/errors/vistaError403.php" );}
    require_once "../controlador/controladorErrors.php";

    if (isset($_COOKIE['usuariNom']))

    $errors = isset($errors) ? $errors : [];
    $correcte = isset($correcte) ? $correcte : null;

    //GOOGLE
    require "../lib/OAuth/configOAuth.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Alba Matamoros Morales -->
    <meta charset="UTF-8">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estils/perfil.css">
    <link rel="stylesheet" href="../estils/general.css">
    <link rel="stylesheet" href="../estils/errors.css">
    <title>Iniciar sessió</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
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
        <div class="container-general-perfil">
            <h2>Iniciar sessió</h2>
            <form action="../controlador/controladorLogin.php" method="POST">
                <label for="usuari">Nom d'Usuari:</label>
                <input type="text" id="usuari" name="usuari" value="<?php if (isset($_COOKIE['usuariNom'])) echo $_COOKIE['usuariNom'] ?>">

                <label for="contrasenya">Contrasenya:</label>
                <input type="password" id="contrasenya" name="contrasenya">

                <?php if (isset($_SESSION['loginRecaptcha']) && $_SESSION['loginRecaptcha'] >= 3): ?>
                    <div class="recaptcha-container">
                        <div class="g-recaptcha" data-sitekey="6LeA3owqAAAAADrlORuAb9IM9WI7O29mDUwJ0IDP"></div>
                    </div>
                <?php endif; ?>

                <label for="recorda" class="checkbox-recordam">
                    <input type="checkbox" id="recorda" name="recorda"> Recorda'm
                </label>

                <input type="submit" name="action" value="Iniciar sessió">
                
                <div class="info-container">
                    <a href="../vista/vistaRecuperarContrasenya.php">Heu oblidat la contrasenya?</a>
                </div>
            </form>

            <div class="msg-info">
                <p>No tens compte? <a href="../vista/vistaRegistrarse.php">Registrat</a></p>
            </div>
            
            <div class="container-iconos">
                <a href="../controlador/HybridAuthC/callbackReddit.php" class="icono-link">
                    <i class="fa-brands fa-reddit"></i>
                </a>
                <a href="<?php echo $url; ?>" class="icono-link">
                    <i class="fa-brands fa-google-plus"></i>
                </a>
            </div>

            <?php 
                if (!isset($errors)) {
                    $errors = [];
                }

                if (!isset($correcte)) {
                    $correcte = null; 
                }

                // CONTROL D'ERRORS
                mostrarMissatge($errors, $correcte);
            ?>
        </div>
    </div>
</body>
</html>
