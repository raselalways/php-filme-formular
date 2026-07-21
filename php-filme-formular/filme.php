<?php

# Konfiguration einbinden
require 'config.php';
# PDO-Objekt bilden
try {
    $pdo = new PDO(DSN, DBUSER, DBPASS);
}
catch(PDOException) {
    die('Keine Datenbankverbindung');
}

# GET-Parameter mit der filter_input()-Funktion auslesen
$genre_id = filter_input(INPUT_GET, 'Genre_id', FILTER_VALIDATE_INT);
# Hashwert empfangen
$gethash = filter_input(INPUT_GET, 'hash');

# stimmt die Genre_id dem Hash nicht überein?
if( hash(URLALGO, $genre_id.HASHSALT) != $gethash ) {
    $genre_id = null;
}

?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/styles.css">
        <title>Filme-Formular</title>
    </head>
    <body>

        <header>
            <h1>Filme-Formular</h1>
        </header>

        <main>
        <?php

        echo '<h2>Genre</h2>';

        # SQL für alle Genre
        $sql = 'SELECT * FROM genre ORDER BY Name';
        # SQL ausführen
        $statement = $pdo->query($sql);
        # Ergebnis durchlaufen
        echo '<ul>';
        while( $row = $statement->fetch(PDO::FETCH_ASSOC) ) {
            
            # Hash-Wert für URL generieren
            $hash = hash(URLALGO, $row['id'].HASHSALT);

            # HTML-String mit Platzhaltern (%s = String, %d = Int)
            $link = '<li><a href="filme.php?Genre_id=%d&hash=%s">%s</a></li>';
            # sprintf() ersetzt Platzhalter durch Werte
            echo sprintf($link, $row['id'], $hash, $row['Name']);
        }
        echo '</ul>';
        # Datenbankergebnis aus dem Speicher löschen 
        $statement = null;


        echo '<h2>Filme</h2>';

        echo '<p><a class="button-link" href="filme-formular.php">Neuer Film</a></p>';

        # wurde ein Genre geklickt, dann die dazugehörigen Filme darstellen 
        if( is_int($genre_id) ) {

            # SQL mit Platzhalter für Filme eines Genre
            $sql = "SELECT * FROM film WHERE Genre_id = :genre_id ORDER BY Erscheinungsdatum DESC"; 
            # SQL vorbereiten und PDOStatement erhalten
            $statement = $pdo->prepare($sql);
            # Platzhalter durch Wert ersetzen, Datentypen prüfen
            $statement->bindParam(':genre_id', $genre_id, PDO::PARAM_INT);
            # SQL ausführen
            $statement->execute();
            
            # Ergebnis durchlaufen
            echo '<ul>';
            while( $row = $statement->fetch(PDO::FETCH_ASSOC) ) {

                $liste = '<li>%s [%s] (%s)</li>';
                echo sprintf($liste, $row['Titel'], $row['Bewertung'], $row['Erscheinungsdatum']);
            }
            echo '</ul>';
            # Ergebnis löschen
            $statement = null;
        }
        else {

            echo 'Bitte ein Genre auswählen';
        }

        ?>
        </main>
        
    </body>
</html>