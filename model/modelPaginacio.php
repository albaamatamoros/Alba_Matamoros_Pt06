<?php
    //Alba Matamoros Morales
    require_once "connexio.php";

    //---------------
    //-- PAGINACIÓ --
    //---------------

    //----------- GLOBALS -----------
    //Consultem els personatges tenint en compte la paginació.
    //ASC
    function consultarPaginacio($pagina, $personatgesPerPag) {
        $offset = ($pagina - 1) * $personatgesPerPag; 
    
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT * FROM personatges ORDER BY nom ASC LIMIT :limit OFFSET :offset');
            $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
            $statement->bindValue(':limit', $personatgesPerPag, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //DESC
    function consultarPaginacioDESC($pagina, $personatgesPerPag) {
        $offset = ($pagina - 1) * $personatgesPerPag; 
    
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT * FROM personatges ORDER BY nom DESC LIMIT :limit OFFSET :offset');
            $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
            $statement->bindValue(':limit', $personatgesPerPag, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //Count de personatges per la paginació.
    function countPersonatges(){
        try {
            $connexio = connexio();
            $contarArticles = $connexio->prepare('SELECT COUNT(*) as total FROM personatges');
            $contarArticles->execute();
            $result = $contarArticles->fetch();
            //Tornem només el número total d'articles per usuari.
            return $result['total'];
        } catch (Exception $e){
            echo "Error: " . $e->getMessage();
        }
    }

    //--------------------------
    //CERCA GLOBAL
    //ASC
    function cercaPersonatgesGlobal($cerca, $pagina, $personatgesPerPag) {
        $offset = ($pagina - 1) * $personatgesPerPag; 
    
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT * FROM personatges WHERE nom LIKE :cerca ORDER BY nom ASC LIMIT :limit OFFSET :offset');
            $statement->bindValue(':cerca', '%' . $cerca . '%', PDO::PARAM_STR);
            $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
            $statement->bindValue(':limit', $personatgesPerPag, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //DESC
    function cercaPersonatgesGlobalDESC($cerca, $pagina, $personatgesPerPag) {
        $offset = ($pagina - 1) * $personatgesPerPag; 
    
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT * FROM personatges WHERE nom LIKE :cerca ORDER BY nom DESC LIMIT :limit OFFSET :offset');
            $statement->bindValue(':cerca', '%' . $cerca . '%', PDO::PARAM_STR);
            $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
            $statement->bindValue(':limit', $personatgesPerPag, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //Count de personatges per la paginació.
    function cercaCountPersonatges($cerca){
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT COUNT(*) as total FROM personatges WHERE nom LIKE :cerca');
            $statement->bindValue(':cerca', '%' . $cerca . '%', PDO::PARAM_STR);
            $statement->execute();
            $result = $statement->fetch();
            //Tornem només el número total d'articles per usuari.
            return $result['total'];
        } catch (Exception $e){
            echo "Error: " . $e->getMessage();
        }
    }

    //----------- USUARI -----------
    //Consultem els personatges per usuari tenint en compte la paginació.
    //ASC
    function consultarPerUsuariPaginacio($usuariId, $pagina, $personatgesPerPag) {
    
        // Calcular el offset
        $offset = ($pagina - 1) * $personatgesPerPag; 
    
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT * FROM personatges WHERE usuari_id = :usuari_id ORDER BY nom ASC LIMIT :limit OFFSET :offset');
            
            //Vinculem els paràmetres id_usuari, limit i offser
            $statement->bindValue(':usuari_id', $usuariId, PDO::PARAM_INT);
            $statement->bindValue(':limit', $personatgesPerPag, PDO::PARAM_INT);
            $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
            
            $statement->execute();
            return $statement->fetchAll();
        } catch (Exception $e) {
            echo "Error: ",$e->getMessage();
        }
    }

    //DES
    function consultarPerUsuariPaginacioDESC($usuariId, $pagina, $personatgesPerPag) {
    
        // Calcular el offset
        $offset = ($pagina - 1) * $personatgesPerPag; 
    
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT * FROM personatges WHERE usuari_id = :usuari_id ORDER BY nom DESC LIMIT :limit OFFSET :offset');
            
            //Vinculem els paràmetres id_usuari, limit i offser
            $statement->bindValue(':usuari_id', $usuariId, PDO::PARAM_INT);
            $statement->bindValue(':limit', $personatgesPerPag, PDO::PARAM_INT);
            $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
            
            $statement->execute();
            return $statement->fetchAll();
        } catch (Exception $e) {
            echo "Error: ",$e->getMessage();
        }
    }

    //Count de personatges per la paginació per usuari.
    function countPersonatgesPerUsuari($usuariId){
        try {
            $connexio = connexio();
            $contarArticles = $connexio->prepare('SELECT COUNT(*) as total FROM personatges WHERE usuari_id = :usuari_id');
            $contarArticles->bindValue(':usuari_id', $usuariId, PDO::PARAM_INT);
            $contarArticles->execute();
            $result = $contarArticles->fetch();
            //Tornem només el número total d'articles.
            return $result['total'];
        } catch (Exception $e){
            echo "Error: " . $e->getMessage();
        }
    }

    //--------------------------
    //CERCA PER USUARI
    //ASC
    function cercaPersonatgesUsuari($cerca, $usuariId, $pagina, $personatgesPerPag) {
    
        // Calcular el offset
        $offset = ($pagina - 1) * $personatgesPerPag; 
    
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT * FROM personatges WHERE usuari_id = :usuari_id AND nom LIKE :cerca ORDER BY nom ASC LIMIT :limit OFFSET :offset');
            
            //Vinculem els paràmetres id_usuari, limit i offser
            $statement->bindValue(':cerca', '%' . $cerca . '%', PDO::PARAM_STR);
            $statement->bindValue(':usuari_id', $usuariId, PDO::PARAM_INT);
            $statement->bindValue(':limit', $personatgesPerPag, PDO::PARAM_INT);
            $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
            
            $statement->execute();
            return $statement->fetchAll();
        } catch (Exception $e) {
            echo "Error: ",$e->getMessage();
        }
    }

    //DESC
    function cercaPersonatgesUsuariDESC($cerca, $usuariId, $pagina, $personatgesPerPag) {
    
        // Calcular el offset
        $offset = ($pagina - 1) * $personatgesPerPag; 
    
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT * FROM personatges WHERE usuari_id = :usuari_id AND nom LIKE :cerca ORDER BY nom DESC LIMIT :limit OFFSET :offset');
            
            //Vinculem els paràmetres id_usuari, limit i offser
            $statement->bindValue(':cerca', '%' . $cerca . '%', PDO::PARAM_STR);
            $statement->bindValue(':usuari_id', $usuariId, PDO::PARAM_INT);
            $statement->bindValue(':limit', $personatgesPerPag, PDO::PARAM_INT);
            $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
            
            $statement->execute();
            return $statement->fetchAll();
        } catch (Exception $e) {
            echo "Error: ",$e->getMessage();
        }
    }

    //Count de personatges per la paginació.
    function cercaCountPersonatgesUsuari($cerca, $usuariId){
        try {
            $connexio = connexio();
            $statement = $connexio->prepare('SELECT COUNT(*) as total FROM personatges WHERE nom LIKE :cerca AND usuari_id = :usuari_id ');
            $statement->bindValue(':cerca', '%' . $cerca . '%', PDO::PARAM_STR);
            $statement->bindValue(':usuari_id', $usuariId, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetch();
            //Tornem només el número total d'articles per usuari.
            return $result['total'];
        } catch (Exception $e){
            echo "Error: " . $e->getMessage();
        }
    }
?>