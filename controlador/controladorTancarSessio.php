<?php
    //Alba Matamoros Morales
    //Iniciem les sessions.
    session_start();
    //Y les tanquem, per tancar sessio.
    session_destroy();
    header("Location: ../index.php");
?>