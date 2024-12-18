<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Alba Matamoros Morales -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estils/estilPerfil.css">
    <link rel="stylesheet" href="../estils/estilBarra.css">
    <link rel="stylesheet" href="../estils/estilError.css">
    <title>Registrar-se</title>
</head>
<body>
    <?php //Verificar si la sessió no està activa. (Comprovació perquè no s'intenti accedir mitjançant ruta).
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION["loginId"])) { header("Location: ../vista/errors/vistaError403.php" );}
        require_once "../controlador/controladorErrors.php";

        $errors = isset($errors) ? $errors : [];
        $correcte = isset($correcte) ? $correcte : null;
    ?>
    <div class="content">
        <!-- HEADER -->
        <nav>
            <!-- INICI y GESTIÓ D'ARTICLES -->
            <div class="left">
                <a href='../index.php'>INICI</a>
            </div>

            <!-- PERFIL -->
            <div class="perfil">
                <a> 
                    <img src="../vista/imatges/imatgesUsers/defaultUser.jpg" class="user-avatar">
                    PERFIL 
                </a>
                <div class="dropdown-content">
                    <a href='../vista/vistaLogin.php'>Iniciar sessió</a>
                    <a href='../vista/vistaRegistrarse.php'>Registrar-se</a>
                </div>
            </div>
        </nav>
        
        <!-- BODY -->
        <div class="login-container">
            <h2>Registrar-se</h2>
            <form action="../controlador/controladorRegistrar.php" method="POST">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value="<?php echo isset ($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '' ; ?>"/>

                <label for="cognoms">Cognoms:</label>
                <input type="text" id="cognoms" name="cognoms" value="<?php echo isset ($_POST['cognoms']) ? htmlspecialchars($_POST['cognoms']) : '' ; ?>"/>

                <label for="usuari">Nom d'Usuari:</label>
                <input type="text" id="usuari" name="usuari" value="<?php echo isset ($_POST['usuari']) ? htmlspecialchars($_POST['usuari']) : '' ; ?>"/>

                <label for="email">Correu Electrònic:</label>
                <input type="email" id="email" name="email" value="<?php echo isset ($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ; ?>"/>

                <label for="contrasenya">Contrasenya:</label>
                <input type="password" id="contrasenya" name="contrasenya">

                <label for="confirmar_contrasenya">Confirmar Contrasenya:</label>
                <input type="password" id="confirmar_contrasenya" name="confirmar_contrasenya">

                <!-- CONTROL D'ERRORS -->
                <?php mostrarMissatge($errors, $correcte) ?>

                <input type="submit" name="action" value="Registrar-se">
            </form>

            <div class="form-footer">
                <p>Ja tens un compte? <a href="../vista/vistaLogin.php">Inicia sessió</a></p>
            </div>
        </div>
    </div>
</body>
</html>