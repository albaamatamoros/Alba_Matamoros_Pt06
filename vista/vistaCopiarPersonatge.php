<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../estils/menu.css">
    <link rel="stylesheet" href="../estils/general.css">
    <link rel="stylesheet" href="../estils/errors.css">
    <link rel="stylesheet" href="../estils/modal.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <title>Copiar Personatge</title>
    <!-- AJAX -->
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
            <a href="../vista/vistaApiPersonatges.php">GRAND LINE</a>
        </div>
        <div class="perfil">
            <a>
                <img src="<?php echo isset($_SESSION['loginImage']) ? $_SESSION['loginImage'] : '../vista/imatges/imatgesUsers/defaultUser.jpg'; ?>" class="user-avatar">
                <?php echo $_SESSION["loginUsuari"] ?? ''; ?>
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
    <!-- GET -->
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
    <div class="content">
        <div class="container-accio">
            <h1>COPIAR PERSONATGE</h1>
            <p>Selecciona les dades que vols copiar del personatge:</p>
            <br>
            <form id="qrForm">
                <div class="container-opcio">
                    <label for="nom">Nom:</label>
                    <input type="text" id="nom" name="nom" value="<?php echo $personatgeBD['nom'] ?? ''; ?>" readonly/>
                    <input type="checkbox" id="copiarNom" name="copiarNom" value="nom">
                </div>
                <div class="container-opcio">
                    <label for="text">Descripció:</label>
                    <input type="text" id="text" name="text" value="<?php echo $personatgeBD['cos'] ?? ''; ?>" readonly/>
                    <input type="checkbox" id="copiarText" name="copiarText" value="text">
                </div>
                <input type="hidden" name="id" value="<?php echo $_GET['id_personatge'] ?? ''; ?>"/>
                <div class="container-grup-botons">
                    <button type="button" id="generateQR" class="boto">Generar QR</button>
                    <button onclick="location.href='../vista/vistaConsultar.php'" type="button" class="boto">Tornar</button>
                </div>
            </form>
        </div>

        <div id="qrModal" class="modal">
            <div class="modal-content">
                <span class="close" id="tancarModal">&times;</span>
                <div id="modalText">
                    <!-- Aquí aparecerá el QR generado -->
                    <img id="qrImage" src="" alt="Código QR" style="display: none;" />
                </div>
                <!-- Botón para iniciar la lectura -->
                <button type="button" id="startReader" class="boto">Llegir QR</button>
                <div id="qr-reader" style="width: 300px; margin-top: 10px;"></div>
                <p id="readResult"></p>
            </div>
        </div>

        <script>
            // Leer QR desde cámara (no desde archivo)
            document.getElementById('startReader').addEventListener('click', function () {
                const resultDiv = document.getElementById("readResult");
                const qrReader = new Html5Qrcode("qr-reader");

                // Iniciar el lector de QR
                qrReader.start({ facingMode: "environment" }, {
                    fps: 10, // Frames por segundo
                    qrbox: 250 // Tamaño del área de escaneo
                }, (decodedText, decodedResult) => {
                    // Mostrar el texto decodificado
                    resultDiv.innerHTML = `Contenido del QR: ${decodedText}`;
                }, (errorMessage) => {
                    // Manejo de errores de escaneo
                    resultDiv.innerText = "No se ha detectado ningún QR. Inténtalo de nuevo.";
                }).catch(err => {
                    // Error al iniciar el lector
                    resultDiv.innerText = "Error al iniciar el lector de QR.";
                });
            });
        </script>

        <script>
            document.getElementById("generateQR").addEventListener("click", function () {

            const modal = document.getElementById("qrModal");
            modal.style.display = "flex";  // El modal es fa visible

            // Creem un objecte FormData per recollir totes les dades del formulari
            const form = document.getElementById("qrForm");
            const formData = new FormData(form);

            // Enviem les dades al servidor amb una petició AJAX utilitzant fetch
            fetch("../controlador/controladorCopiarPersonatge.php", {
                method: "POST",
                body: formData
            })

            // Quan el servidor respongui, executarem aquesta funció
            .then(response => response.text())
                .then(data => {
                    //Actualitzem el contingut del modal
                    const modalText = document.getElementById("modalText");
                    modalText.innerHTML = data;
                })
                .catch(error => {
                    const modalText = document.getElementById("modalText");
                    modalText.innerHTML = `<p>Error al generar el QR. Intenta'l de nou.</p>`;
                });
            });

            document.addEventListener("DOMContentLoaded", function () {
                //esdeveniment tancar modal
                document.getElementById("tancarModal").addEventListener("click", function () {
                    // Quan es fa clic al botó de tancar, amaguem el modal
                    const modal = document.getElementById("qrModal");
                    modal.style.display = "none";  // El modal es fa invisible
                });
            });
        </script>
    </div>
</body>
</html>
