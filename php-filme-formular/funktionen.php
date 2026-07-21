<?php

/**
 * liest einen POST-Parameter aus, begrenzt und trimmt diesen
 * @param string $name Name des POST-Parameters
 * @param int $laenge Anzahl der begrenzten Zeichen
 * @return string der getrimmte und begrenzte POST-Parameter
 */
function myPost(string $name, int $laenge = 50): string {

    if( isset($_POST[$name]) ) {
        return trim( substr( $_POST[$name], 0, $laenge ) );
    }
    else {
        return '';
    }
}



