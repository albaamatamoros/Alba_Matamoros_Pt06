<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Alba Matamoros Morales -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ESTILS -->
    <link rel="stylesheet" href="../estils/general.css">
    <link rel="stylesheet" href="../estils/proves.css">
    <title>Api</title>
</head>
<body>
    <?php //Verificar si la sessió no està activa. (Comprovació perquè no s'intenti accedir mitjançant ruta).
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION["loginId"])) { header("Location: ../vista/errors/vistaError403.php" );}

        require_once "../controlador/Api/controladorOnePiece.php";
    ?>
    
    <nav>
        <!------------------------>
        <!-- BARRA DE NAVEGACIÓ -->
        <!------------------------>

        <!-- INICI y GESTIÓ D'ARTICLES -->
        <div class="left">
        <a href="../index.php">INICI</a>
            <!-- Botó activat amb l'inici de sessió fet "GESTIÓ DE PERSONATGES" -->
            <?php if(isset($_SESSION["loginId"])) {
                echo ' <a href="../vista/vistaMenu.php">GESTIÓ DE PERSONATGES</a> ';
            } ?>
            <?php if(isset($_SESSION["loginId"])) {
                echo ' <a href="../vista/vistaMenu.php">GRAND LINE</a> ';
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
                    <img src="<?php echo isset($_SESSION['loginImage']) ? $_SESSION['loginImage'] : "../vista/imatges/imatgesUsers/defaultUser.jpg" ; ?>" class="user-avatar"><?php 
                        $nomUsuari = $_SESSION["loginUsuari"]; 
                        echo $nomUsuari;
                    ?> 
                </a>
                <div class="dropdown-content">
                    <a href="../vista/vistaPerfil.php">Administrar perfil</a>
                    <?php if (isset($_SESSION["loginAutentificacio"]) && $_SESSION["loginAutentificacio"] == ""): ?>
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
    <div class="content-api">
        <div class="container-botons-api">
            <div class="card">
                <h2>PIRATES</h2>
                <a href="../vista/vistaApiPersonatges.php?boto_seleccionat=pirates">
                    <img src="../vista/imatges/Piratas.jpg">
                </a>
            </div>
            <div class="card">
                <h2>MARINA</h2>
                <a href="../vista/vistaApiPersonatges.php?boto_seleccionat=marina">
                    <img src="../vista/imatges/Marine.webp">
                </a>
            </div>
            <div class="card">
                <h2>API PROPIA</h2>
                <a href="../vista/vistaApiPersonatges.php?boto_seleccionat=api_propia">
                    <img src="../vista/imatges/Propi.jpg">
                </a>
            </div>
            <div class="card">
                <h2>PERSONATGES</h2>
                <a href="../vista/vistaApiPersonatges.php?boto_seleccionat=personatges">
                    <img src="../vista/imatges/Personatges.jpg">
                </a>
            </div>
        </div>
        <div>
            <?php
                if (isset($_GET['boto_seleccionat'])) {
                    $botoSeleccionat = $_GET['boto_seleccionat'];

                    switch ($botoSeleccionat) {
                        case 'pirates':
                            echo '<div class="titolsApi"><h2>PIRATES</h2></div>';
                            break;
                        case 'marina':
                            echo '<div class="titolsApi"><h2>MARINA</h2></div>';
                            $totsElsPersonatges = getAllCharacters("Marine");
                
                            if (empty($totsElsPersonatges)) {
                                echo "<p>No se encontraron personajes o hubo un problema con la API.</p>";
                            } else {
                                mostrarPersonatges($totsElsPersonatges);
                            }
                            break;
                        case 'api_propia':
                            echo '<div class="titolsApi"><h2>API PROPIA</h2></div>';
                            break;
                        case 'personatges':
                            echo '<div class="titolsApi"><h2>TOTS ELS PERSONATGES</h2></div>';
                            $totsElsPersonatges = getAllCharacters("");
                
                            if (empty($totsElsPersonatges)) {
                                echo "<p>No se encontraron personajes o hubo un problema con la API.</p>";
                            } else {
                                mostrarPersonatges($totsElsPersonatges);
                            }
                            break;
                        default:
                            echo '<div><h2>No se ha seleccionado una opción válida.</h2><p>Por favor, selecciona una opción válida.</p></div>';
                            break;
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>
