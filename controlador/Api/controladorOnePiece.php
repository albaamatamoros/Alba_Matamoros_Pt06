<?php
    function getAllCharacters($filtre) {
        $apiOnePiece = "https://api.api-onepiece.com/v2/characters/en";
        $totalPersonatges = [];
    
        $jsonData = file_get_contents($apiOnePiece);
        $data = json_decode($jsonData, true);
    
        $totalPersonatges = array_map(function($character) {
            return [
                'name' => isset($character['name']) && !empty($character['name']) ? $character['name'] : 'Desconegut',
                'bounty' => isset($character['bounty']) && !empty($character['bounty']) ? $character['bounty'] : 'Sense Recompensa',
                'crew' => isset($character['crew']['name']) && !empty($character['crew']['name']) ? $character['crew']['name'] : 'Sense tripulació',
                'fruit' => isset($character['fruit']['name']) ? $character['fruit']['name'] : 'Sense fruita'
            ];
        }, $data);

        if ($filtre) {
            $totalPersonatges = array_filter($totalPersonatges, function($character) use ($filtre) {
                return strpos(strtolower($character['crew']), strtolower($filtre)) !== false;
            });
        }
    
        return $totalPersonatges;
    }
    

    function mostrarPersonatges($characters) {
        echo "<div class='container-personatges-api'>";  // Contenedor para las fichas

        foreach ($characters as $character) {
            echo "<div class='ficha-personaje'>";
            echo "<h2 class='titulo-ficha'>" . htmlspecialchars($character['name']) . "</h2>";
            echo "<p><strong>Recompensa:</strong> " . htmlspecialchars($character['bounty']) . "</p>";
            echo "<p><strong>Tripulació:</strong> " . htmlspecialchars($character['crew']) . "</p>";
            echo "<p><strong>Fruita:</strong> " . htmlspecialchars($character['fruit']) . "</p>";
            echo "</div>";
        }

        echo "</div>";
    }
?>
