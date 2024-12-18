<?php
    //Alba Matamoros Morales
    require_once "connexio.php";
    //------------
    //- USUARIOS -
    //------------

    //********************************************************
    //SELECT

    //Comprovar Usuari I Contrasenya exsistent.
    function comprovarUsuariIContrasenya($usuari, $contrasenya){
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT * FROM usuaris WHERE usuari = :usuari AND contrasenya = :contrasenya');
            $statement->execute(
                array(
                ':usuari' => $usuari,
                ':contrasenya' => $contrasenya)
            );
            return $statement->fetch();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //Comprovar Usuari I Email.
    function comprovarUsuariIEmail($usuari, $email){
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT * FROM usuaris WHERE correu = :correu OR usuari = :usuari');
            $statement->execute(
                array(
                ':correu' => $email,
                ':usuari' => $usuari)
            );
            return $statement->fetch();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //comprovem l'usuari i agafem la contrasenya.
    function comprovarExistensiaDUsuari($usuari){
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT * FROM usuaris WHERE usuari = :usuari');
            $statement->execute(
                array(
                ':usuari' => $usuari)
            );
            return $statement->fetch();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //Comprovar la contrasenya per id.
    function comprovarContrasenyaId($usuariId){
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT * FROM usuaris WHERE id_usuari = :id_usuari');
            $statement->execute(
                array(
                ':id_usuari' => $usuariId)
            );
            return $statement->fetch();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function comprovarNomUsuariExistent($nomUsuari, $usuariId){
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT * FROM usuaris WHERE usuari = :usuari AND id_usuari != :id_usuari');
            $statement->execute(
                array(
                    ':usuari' => $nomUsuari, 
                    ':id_usuari' => $usuariId 
                )
            );
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function comprovarEmail($email){
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT * FROM usuaris WHERE correu = :correu');
            $statement->execute(
                array(
                ':correu' => $email)
            );
            return $statement->fetch();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function comprovarToken($token) {
        $connexio = connexio();

        $statement = $connexio->prepare(' SELECT * FROM usuaris WHERE token = :token AND token_time > :current_time');
        
        $statement->bindParam(':token', $token);
        $currentTime = time();
        $statement->bindParam(':current_time', $currentTime);
        $statement->execute();
        $result = $statement->fetch();
        
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    

    //********************************************************
    //INSERT

    //Insertar nou Usuari.
    function insertarNouUsuari($nom, $cognoms, $usuari, $email, $contrasenya){
        try {
            //Senteècia per inserir
            $connexio = connexio();
            $statement = $connexio->prepare('INSERT INTO usuaris (nom, cognoms, correu, usuari, contrasenya) VALUES (:nom, :cognoms, :correu, :usuari, :contrasenya)');
            $statement->execute( 
            array(
            ':nom' => $nom, 
            ':cognoms' => $cognoms,
            ':correu' => $email,
            ':usuari' => $usuari,
            ':contrasenya' => $contrasenya)
            );
        }catch (Exception $e){
            echo "Error: " . $e->getMessage();
        }
    }

    //Insertar Usuari per HybridAuth.
    function insertarNouUsuariHybridAuth($userProfile){
        try {
            $email = "No proporcionat";
            $connexio = connexio();
            $statement = $connexio->prepare('INSERT INTO usuaris (usuari, correu, autentificacio) VALUES (:usuari, :correu, :autentificacio)');
            $statement->execute(
            array(
            ':usuari' => $userProfile->displayName,
            ':correu' => $userProfile->email,
            ':autentificacio' => 'Reddit')
            );
        }catch (Exception $e){
            echo "Error: " . $e->getMessage();
        }
    }

    //Insertar Usuari per HybridAuth.
    function insertarNouUsuariOAuth($usuari, $email, $nom, $cognom){
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('INSERT INTO usuaris (usuari, nom, cognoms, correu, autentificacio) VALUES (:usuari, :nom, :cognoms, :correu, :autentificacio)');
            $statement->execute(
            array(
            ':usuari' => $usuari,
            ':correu' => $email,
            ':nom' => $nom,
            ':cognoms' => $cognom,
            ':autentificacio' => 'Google')
            );
        }catch (Exception $e){
            echo "Error: " . $e->getMessage();
        }
    }

    //********************************************************
    //MODIFICAR

    //modificar la contrasenya de l'usuari.
    function modificarContrasenya($contrasenyaCifrada, $usuariId){
        try {
            //Fem un update que modifica totes les dades a les noves introduides.
            $connexio = connexio();
            $statement = $connexio->prepare('UPDATE usuaris SET contrasenya = :contrasenya WHERE id_usuari = :id_usuari');
            $statement->execute( 
            array(
            ':contrasenya' => $contrasenyaCifrada,
            ':id_usuari' => $usuariId)
            );
        }catch (Exception $e){
            echo "Error: " . $e->getMessage();
        }
    }

    function modificarNomUsuari($nomUsuari, $usuariId){
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('UPDATE usuaris SET usuari = :usuari WHERE id_usuari = :id_usuari');
            $statement->execute( 
            array(
            ':usuari' => $nomUsuari,
            ':id_usuari' => $_SESSION["loginId"])
            );
        }catch (Exception $e){
            echo "Error: " . $e->getMessage();
        }
    }

    function modificarImatgePerfilUsuari($urlImatge, $usuariId) {
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('UPDATE usuaris SET imatge = :imatge WHERE id_usuari = :id_usuari');
            $statement->execute( 
            array(
            ':imatge' => $urlImatge,
            ':id_usuari' => $usuariId)
            );
        }catch (Exception $e){
            echo "Error: " . $e->getMessage();
        }
    }

    function guardarToken($email, $token, $expires) {
        try {
            $connexio = connexio();
    
            $statement = $connexio->prepare("UPDATE usuaris SET token = :token, token_time = :token_time WHERE correu = :correu");
            $statement->bindParam(':token', $token);
            $statement->bindParam(':token_time', $expires); // Guardamos el tiempo de expiración
            $statement->bindParam(':correu', $email);
            $statement->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        } 
    }

    //********************************************************
    //INICIAR SESSIÓN
    
    //Agafar les dades d'inici sessió.
    function iniciSessio($usuari){
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT id_usuari, correu, usuari, nom, cognoms, imatge, administrador, autentificacio FROM usuaris WHERE usuari = :usuari');
            $statement->execute(
                array(
                    ':usuari' => $usuari)
            );
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function iniciSessioOAuth($usuari, $email){
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT id_usuari, correu, usuari, nom, cognoms, imatge, administrador, autentificacio FROM usuaris WHERE usuari = :usuari AND correu = :correu');
            $statement->execute(
                array(
                ':usuari' => $usuari,
                ':correu' => $email
                )
            );
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //********************************************************
    //ESBORRAR

    function esborrarUsuariPerId($idUsuari){
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('DELETE FROM usuaris WHERE id_usuari = :id_usuari');
            $statement->execute(array(':id_usuari' => $idUsuari));
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //********************************************************
    //MOSTRAR USUARIS
    function mostrarTotsElsUsuaris($usuariId){
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT * FROM usuaris WHERE id_usuari != :id_usuari AND administrador = 0');
            $statement->execute(array(':id_usuari' => $usuariId));
            
            // Usamos fetchAll() para obtener todos los resultados
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

?>