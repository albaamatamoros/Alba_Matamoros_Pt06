<?php 
    //Alba Matamoros Morales
    require_once "connexio.php";

    //---------------
    //- PERSONATGES -
    //---------------

    //********************************************************

    //INSERT
    //Inserir nou personatge.
    function inserir($nom, $text, $usuariId){
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('INSERT INTO personatges (nom, cos, usuari_id) VALUES (:nom, :cos, :usuari_id)');
            $statement->execute( 
            array(
            ':nom' => $nom, 
            ':cos' => $text,
            ':usuari_id' => $usuariId)
            );
        }catch (Exception $e){
            echo "Error: " . $e->getMessage();
        }
    }

    //********************************************************
    //UPDATE

    //Modificar personatge.
    function modificar($nom, $text, $id){
        try {
            //Fem un update que modifica totes les dades a les noves introduides.
            $connexio = connexio();
            $statement = $connexio->prepare('UPDATE personatges SET nom = :nom, cos = :cos WHERE id_personatge = :id_personatge');
            $statement->execute( 
            array(
            ':nom' => $nom, 
            ':cos' => $text,
            ':id_personatge' => $id)
            );
        }catch (Exception $e){
            echo "Error: " . $e->getMessage();
        }
    }

    //********************************************************
    //DELETE

    //Esborrem personatge.
    function esborrar($nom){
        try {
            //Sentència per esborrar.
            $connexio = connexio();
            $statement = $connexio->prepare('DELETE FROM personatges WHERE nom = :nom');
            $statement->execute( 
                array(
                ':nom' => $nom
                )
            );
        } catch (Exception $e){
            echo "Error: " . $e->getMessage();
        }
    }

    //esborrar personatge per id.
    function esborrarPerId($idPersonatge){
        try {
            //Sentència per esborrar per id.
            $connexio = connexio();
            $statement = $connexio->prepare('DELETE FROM personatges WHERE id_personatge = :id_personatge');
            $statement->execute( 
                array(
                ':id_personatge' => $idPersonatge
                )
            );
        } catch (Exception $e){
            echo "Error: " . $e->getMessage(); 
        }
    }

    //********************************************************
    //SELECT

    //Comprovacio per Nom.
    function selectComprovarNom($nom){
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT nom FROM personatges WHERE nom = :nom');
            $statement->execute(array(':nom' => $nom));
            //Retornem dades o FALSE per saber si exsisteix o no.
            return $statement->fetch(); 
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //Obtenir id_personatge per el nom.
    function obtenerIdDelPersonatgePerNom($nom){
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT id_personatge FROM personatges WHERE nom = :nom');
            $statement->execute(array(':nom' => $nom));
            //Retornem dades o FALSE per saber si exsisteix o no.
            return $statement->fetchColumn(); 
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //Comprovacio per id.
    function selectComprovarId($id){
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT id_personatge FROM personatges WHERE id_personatge = :id_personatge');
            $statement->execute(array(':id_personatge' => $id));            
            return $statement->fetch();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //Comprovar id i nom.
    function selectComprovarIdINom($id, $nom){
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT * FROM personatges WHERE id_personatge = :id_personatge AND nom = :nom');
            $statement->execute(
                array(
                ':id_personatge' => $id,
                ':nom' => $nom)
            );
            return $statement->fetch();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //Comprovar si exsisteix un personatge amb nom i usuariID.
    function selectComprovarUsuariId($nom, $usuariId){
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT * FROM personatges WHERE usuari_id = :usuari_id AND nom = :nom');
            $statement->execute(
                array(
                ':usuari_id' => $usuariId,
                ':nom' => $nom)
            );
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //Comprovacio d'un article en concret per id per poder fer modificació de les seves dades.
    function selectPersonatgePerId($id) {
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT * FROM personatges WHERE id_personatge = :id_personatge');
            $statement->execute(array(':id_personatge' => $id));
            return $statement->fetch();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    //CONSULTAR
    //Mostrar tots els articles.
    function consultar(){
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT * FROM personatges');
            $statement->execute();
            return $statement->fetchAll();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //Consultar personatges per usuari en concret.
    function consultarPerUsuari($usuariId){
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT * FROM personatges WHERE usuari_id = :usuari_id');
            $statement->execute(array(':usuari_id' => $usuariId));
            return $statement->fetchAll();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>