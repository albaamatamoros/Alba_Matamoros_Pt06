<?php
    function mostrarMissatge($errors = [], $correcte = '') {
        if (!empty($errors)) {
            echo '<div class="alert error-container">';
            echo '<span class="alert-icon error-icon">⚠️</span>';
            echo '<div>';
            foreach ($errors as $error) {
                echo '<p class="alert-text error-message">' . htmlspecialchars($error) . '</p>';
            }
            echo '</div>';
            echo '</div>';
        } elseif (!empty($correcte)) {
            echo '<div class="alert success-container">';
            echo '<span class="alert-icon success-icon">✔️</span>'; 
            echo '<div>';
            echo '<p class="alert-text success-message">' . htmlspecialchars($correcte) . '</p>';
            echo '</div>';
            echo '</div>';
        }
    }

    function mostrarMissatgeError($errors = []) {
        if (!empty($errors)) {
            echo '<div class="alert error-container">';
            echo '<span class="alert-icon error-icon">⚠️</span>';
            echo '<div>';
            foreach ($errors as $error) {
                echo '<p class="alert-text error-message">' . htmlspecialchars($error) . '</p>';
            }
            echo '</div>';
            echo '</div>';
        }
    }
?>