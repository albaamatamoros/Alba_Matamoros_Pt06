<?php 
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $search = isset($_POST['search']) ? $_POST['search'] : (isset($_GET['search']) ? $_GET['search'] : "");

        if (isset($_POST['select'])) {  
            setcookie("personatgesCookie", $_POST['select'], 0);

            $redirectUrl = "../vista/vistaConsultar.php";
            if (!empty($search)) {
                $redirectUrl .= "?search=" . urlencode($search);
            }
            header("Location: " . $redirectUrl);
            exit;
        } 
    
        if (isset($_POST['selectOrdenacio'])) {
            setcookie("ordenacioCookie", $_POST['selectOrdenacio'], 0);
            
            $redirectUrl = "../vista/vistaConsultar.php";
            if (!empty($search)) {
                $redirectUrl .= "?search=" . urlencode($search);
            }
            header("Location: " . $redirectUrl);
            exit;
        }
    }

    if (!isset($_COOKIE['personatgesCookie'])) { setcookie("personatgesCookie", 5, 0); }
    if (!isset($_COOKIE['ordenacioCookie'])) { setcookie("ordenacioCookie", "ASC", 0); }
    require_once '../controlador/controladorPaginacio.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Alba Matamoros Morales -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../estils/general.css">
    <link rel="stylesheet" href="../estils/mostrar.css">
    <link rel="stylesheet" href="../estils/paginacio.css">
    <title>Consultar personatges</title>
</head>
<body>
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

    <!------------------------->
    <!-- MOSTRAR PERSONATGES -->
    <!------------------------->

    <section class="blocPersonatges">
        <!------------------------->
        <!-- PERSONATGES GLOBALS -->
        <!------------------------->
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

        <!-- Titulo -->
        <div class="titulo"> <h1 class="titulo-personatges">Llista de Personatges Global</h1></div>
        
        <!---------------->
        <!-- SEARCH BAR -->
        <!---------------->
        <div class="search-bar-container">
            <form method="GET" action="vistaConsultar.php" class="search-form">
                <input type="search" name="search" placeholder="Cerca..." class="search-input" value="<?php echo $cerca; ?>"/>
                <button type="submit" class="search-button"><i class="fa-solid fa-magnifying-glass" style="color:rgb(255, 255, 255);"></i></button>
            </form>
        </div>

        <div class="personatges-container">
            <!-- Paginación Global -->
            <?php echo paginacioGlobal(); ?>
        </div>

        <!-- PAGINACIÓ GLOBAL -->
        <!-- Cridem a la funció que fa els càlculs i configura la paginació. -->
        <section class="paginacio">
            <div class="pagination">
                <!-- Global -->
                <?php echo retornarLinksGlobal(); ?>
            </div>
        </section>
    </section>
</body>
</html>