<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estils/estilPersonatges.css">
    <link rel="stylesheet" href="../estils/estilBarra.css">
    <link rel="stylesheet" href="../estils/estilError.css">
    <link rel="stylesheet" href="../estils/modal.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Copiar Personatge</title>
</head>
<body>
    <?php
        //Verificar si la sessió no està activa. (Comprovació perquè no s'intenti accedir mitjançant ruta).
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION["loginId"])) { header("Location: ../vista/errors/vistaError403.php" );}
        require_once "../controlador/controladorCopiarPersonatge.php";
        require_once "../controlador/controladorErrors.php";
        require_once '../lib/chillerlan/vendor/autoload.php';
        use chillerlan\QRCode\QRCode;

    ?>
    <nav>
        <div class="left">
            <a href='../index.php'>INICI</a>
            <a href="../vista/vistaMenu.php">GESTIÓ DE PERSONATGES</a>
        </div>
        <div class="perfil">
            <a>
                <img src="<?php echo isset($_SESSION['loginImage']) ? $_SESSION['loginImage'] : '../vista/imatges/imatgesUsers/defaultUser.jpg'; ?>" class="user-avatar">
                <?php echo $_SESSION["loginUsuari"] ?? ''; ?>
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

    <?php
        if (isset($_GET["id_personatge"])) {
            $_SESSION["personatgeIdCopiat"] = $_GET["id_personatge"];
        }
        if (isset($_SESSION["personatgeIdCopiat"])) {
            $personatgeBD = dadesPersonatge($_SESSION["personatgeIdCopiat"]);
            if (empty($personatgeBD)) {
                $errors[] = "No s'han trobat dades per a aquest personatge.";
            }
        } else {
            $errors[] = "No s'han trobat dades per a aquest personatge.";
        }
    ?>

    <div class="button-container">
        <h1>COPIAR PERSONATGE</h1>
        <p>Selecciona les dades que vols copiar del personatge:</p>
        <br>
        <form id="qrForm">
            <div class="recuadro">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value="<?php echo $personatgeBD['nom'] ?? ''; ?>" readonly/>
                <input type="checkbox" id="copiarNom" name="copiarNom" value="nom">
            </div>
            <div class="recuadro">
                <label for="text">Descripció:</label>
                <input type="text" id="text" name="text" value="<?php echo $personatgeBD['cos'] ?? ''; ?>" readonly/>
                <input type="checkbox" id="copiarText" name="copiarText" value="text">
            </div>
            <input type="hidden" name="id" value="<?php echo $_GET['id_personatge'] ?? ''; ?>"/>
            <div class="button-group">
                <button type="button" id="generateQR" class="btn btn-primary">Generar QR</button>
                <button onclick="location.href='../vista/vistaConsultar.php'" type="button" class="btn">Tornar</button>
            </div>
        </form>
    </div>

    <!-- Modal -->
    <div id="qrModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <div id="modalBody">
                <div class="spinner"></div>
                <p>Generando QR...</p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("generateQR").addEventListener("click", function () {
            // Mostrar el modal
            const modal = document.getElementById("qrModal");
            modal.style.display = "flex";

            // Crear objeto FormData con los datos del formulario
            const form = document.getElementById("qrForm");
            const formData = new FormData(form);

            // Enviar los datos al servidor usando fetch
            fetch("../controlador/generarQR.php", {
                method: "POST",
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    // Mostrar el resultado en el modal
                    const modalBody = document.getElementById("modalBody");
                    modalBody.innerHTML = `<img src="data:image/png;base64,${data}" alt="Código QR"/>`;
                })
                .catch(error => {
                    console.error("Error:", error);
                    const modalBody = document.getElementById("modalBody");
                    modalBody.innerHTML = `<p>Error al generar el QR. Inténtalo de nuevo.</p>`;
                });
        });

        // Cerrar el modal
        document.getElementById("closeModal").addEventListener("click", function () {
            const modal = document.getElementById("qrModal");
            modal.style.display = "none";
        });
    </script>

</body>
</html>
