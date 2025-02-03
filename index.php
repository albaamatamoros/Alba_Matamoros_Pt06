<?php 
    //Crear cookies per recordar les preferencies d'usuari a l'hora de mostrar x personatges per pantalla. i ordenació.
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $search = isset($_POST['search']) ? $_POST['search'] : (isset($_GET['search']) ? $_GET['search'] : "");

        if (isset($_POST['select'])) {  
            setcookie("personatgesCookie", $_POST['select'], 0);

            $redirectUrl = "index.php";
            if (!empty($search)) {
                $redirectUrl .= "?search=" . urlencode($search);
            }
            header("Location: " . $redirectUrl);
            exit;
        } 

        if (isset($_POST['selectOrdenacio'])) {
            setcookie("ordenacioCookie", $_POST['selectOrdenacio'], 0);

            $redirectUrl = "index.php";
            if (!empty($search)) {
                $redirectUrl .= "?search=" . urlencode($search);
            }
            header("Location: " . $redirectUrl);
            exit;
        }
    }

    if (!isset($_COOKIE['personatgesCookie'])) { setcookie("personatgesCookie", 5, 0); }
    if (!isset($_COOKIE['ordenacioCookie'])) { setcookie("ordenacioCookie", "ASC", 0); }

    require_once './controlador/controladorPaginacio.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Alba Matamoros Morales -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ESTILS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="estils/general.css">
    <link rel="stylesheet" href="estils/mostrar.css">
    <link rel="stylesheet" href="estils/paginacio.css">
    <title>Inici</title>
    <!-- Script confirmació esborrar personatges -->
    <script>
        function confirmarEsborrar(idPersonatge) {
            let confirmacion = confirm("Segur que vols esborrar aquest personatge?");
            
            if (confirmacion) {
                // Redirigeix + id personatge.
                window.location.href = './controlador/controladorEsborrar.php?id_personatge=' + idPersonatge;
            }
        }
    </script>
</head>
<body>
    <nav>
        <!------------------------>
        <!-- BARRA DE NAVEGACIÓ -->
        <!------------------------>

        <!-- INICI y GESTIÓ D'ARTICLES -->
        <div class="left">
        <a href="index.php">INICI</a>
            <!-- Botó activat amb l'inici de sessió fet "GESTIÓ DE PERSONATGES" -->
            <?php if(isset($_SESSION["loginId"])) {
                echo ' <a href="vista/vistaMenu.php">GESTIÓ DE PERSONATGES</a> ';
            } ?>
            <?php if(isset($_SESSION["loginId"])) {
                echo ' <a href="vista/vistaApiPersonatges.php">ARXIU PIRATA</a> ';
            } ?>
        </div>

        <!------------>
        <!-- PERFIL -->
        <!------------>
        <div class="perfil">
            <!-- Botons de perfil -->
            <?php if (!isset($_SESSION['loginId'])): ?>
                <a>
                    <img src="vista/imatges/imatgesUsers/defaultUser.jpg" class="user-avatar">
                    PERFIL
                </a>
                <div class="dropdown-content">
                    <a href="vista/vistaLogin.php">Iniciar sessió</a>
                    <a href="vista/vistaRegistrarse.php">Registrar-se</a>
            <?php else: ?>
                <a>
                    <img src="<?php echo isset($_SESSION['loginImage']) ? substr($_SESSION['loginImage'], 1) : "vista/imatges/imatgesUsers/defaultUser.jpg" ; ?>" class="user-avatar">
                    <?php
                        $nomUsuari = $_SESSION["loginUsuari"]; 
                        echo $nomUsuari;
                    ?> 
                </a>
                <div class="dropdown-content">
                    <a href="vista/vistaPerfil.php">Administrar perfil</a>
                    <?php if (isset($_SESSION["loginAutentificacio"]) && $_SESSION["loginAutentificacio"] == ""): ?>
                        <a href="vista/vistaCanviContra.php">Canviar contrasenya</a>
                    <?php endif; ?>
                    <?php if ($_SESSION["loginAdministrador"] == 1): ?>
                        <a href="vista/vistaAdministrarUsuaris.php">Administrar usuaris</a>
                    <?php endif; ?>
                    <a href="./controlador/controladorTancarSessio.php">Tancar sessió</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!------------------------->
    <!-- MOSTRAR PERSONATGES -->
    <!------------------------->
    
    <section class="blocPersonatges">
        <?php if (!isset($_SESSION['loginId'])): ?>

            <!------------------------->
            <!-- PERSONATGES GLOBALS -->
            <!------------------------->

            <!-- Titulo -->
            <div class="titulo"> <h1 class="titulo-personatges">Llista de Personatges Global</h1></div>
                <!-- Tornem la consulta amb tots els peronatges globals -->

                <div class="selectPersonatge">
                    <form action="" method="POST">
                        <select name="select" onchange="this.form.submit()">
                            <?php foreach([5, 10, 15, 20] as $num): ?>
                                <option value="<?php echo $num; ?>" <?php if (isset($_COOKIE['personatgesCookie']) && $_COOKIE['personatgesCookie'] == $num) echo 'selected'; ?>>
                                    <?php echo $num; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>

                <div class="selectPersonatgeOrdenacio">
                    <form action="" method="POST">
                        <select name="selectOrdenacio" onchange="this.form.submit()">
                            <?php foreach(["ASC", "DESC"] as $ordenacio): ?>
                                <option value="<?php echo $ordenacio; ?>" <?php if (isset($_COOKIE['ordenacioCookie']) && $_COOKIE['ordenacioCookie'] == $ordenacio) echo 'selected'; ?>>
                                    <?php echo $ordenacio; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>
            <!----------------------->
            <!-- Search bar global -->
            <!----------------------->

            <div class="search-bar-container">
                <form method="GET" action="index.php" class="search-form">
                    <input type="search" name="search" placeholder="Cerca..." class="search-input" value="<?php echo $cerca; ?>"/>
                    <button type="submit" class="search-button"><i class="fa-solid fa-magnifying-glass" style="color:rgb(255, 255, 255);"></i></button>
                </form>
            </div>

            <!----------------------------------------->
            <!--- Paginació Global, links i mostrar --->
            <!----------------------------------------->
            <div class="personatges-container">
                <!-- Paginación Global -->
                <?php 
                    echo paginacioGlobal(); 
                ?>
            </div>

            <!-- PAGINACIÓ GLOBAL -->
            <!-- Cridem a la funció que fa els càlculs i configura la paginació. -->
            <section class="paginacio">
                <div class="pagination">
                    <!-- Global -->
                    <?php echo retornarLinksGlobal(); ?>
                </div>
            </section>

        <?php else: ?>

            <!------------------------>
            <!-- PERSONATGES USUARI -->
            <!------------------------>
            <!-- Cookies per recordar les preferencies d'usuari a l'hora de mostrar x personatges per pantalla -->
             
            <div class="selectPersonatge">
                <form action="" method="POST">
                    <select name="select" onchange="this.form.submit()">
                        <?php foreach([5, 10, 15, 20] as $num): ?>
                            <option value="<?php echo $num; ?>" <?php if (isset($_COOKIE['personatgesCookie']) && $_COOKIE['personatgesCookie'] == $num) echo 'selected'; ?>>
                                <?php echo $num; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>

            <!-- Titulo -->
            <div class="titulo"> <h1 class="titulo-personatges">Llista de Personatges</h1></div>

            <!----------------------->
            <!-- Search bar Usuari -->
            <!----------------------->
            <div class="search-bar-container">
                <form method="GET" action="index.php" class="search-form">
                    <input type="search" name="search" placeholder="Cerca..." class="search-input" value="<?php echo $cerca; ?>"/>
                    <button type="submit" class="search-button"><i class="fa-solid fa-magnifying-glass" style="color:rgb(255, 255, 255);"></i></button>
                </form>
            </div>

            <div class="selectPersonatgeOrdenacio">
                <form action="" method="POST">
                    <select name="selectOrdenacio" onchange="this.form.submit()">
                        <?php foreach(["ASC", "DESC"] as $ordenacio): ?>
                            <option value="<?php echo $ordenacio; ?>" <?php if (isset($_COOKIE['ordenacioCookie']) && $_COOKIE['ordenacioCookie'] == $ordenacio) echo 'selected'; ?>>
                                <?php echo $ordenacio; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>

            <!----------------------------------------->
            <!--- Paginació Usuari, links i mostrar --->
            <!----------------------------------------->
            <!-- PERSONATGES USUARI -->
            <div class="personatges-container">
                <?php echo paginacioPerUsuari(); ?>
            </div>

            <!-- PAGINACIÓ PER USUARI -->
            <!-- Cridem a la funció que fa els càlculs i configura la paginació. -->
            <section class="paginacio">
            <div class="pagination">
                <!-- Tornem la consulta amb tots els peronatges globals -->
                <?php echo retornarLinksPerUsuari(); ?>
            </div>
            </section>
        <?php endif; ?>
    </section>
</body>
</html>
