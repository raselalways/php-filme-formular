<?php

# Konfiguration einbinden
require 'config.php';
# Funktionen
require 'funktionen.php';

# PDO-Objekt bilden
try {
    $pdo = new PDO(DSN, DBUSER, DBPASS);
}
catch(PDOException) {
    die('Keine Datenbankverbindung');
}

# Formulardaten empfangen
$genre_id = myPost('Genre_id', 5);
$titel = myPost('Titel', 150);
$erscheinungsdatum = myPost('Erscheinungsdatum', 10);
$beschreibung = myPost('Beschreibung', 2000);
$button = myPost('Button', 20);

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


        ?>

        <form action="filme-formular.php" method="post">

            <label for="Genre_id">Genre *</label>
            <select name="Genre_id" id="Genre_id" required class="eingabe">
                <option value="">Bitte auswählen</option>
                <?php
                # SQL für alle Genre
                $sql = 'SELECT * FROM genre ORDER BY Name';
                # SQL ausführen
                $statement = $pdo->query($sql);
                # Ergebnis durchlaufen
                while( $row = $statement->fetch(PDO::FETCH_ASSOC) ) {

                    if($row['id'] == $genre_id) {
                        $selected = 'selected';
                    }
                    else {
                        $selected = '';
                    }

                    $html = '<option %s value="%d">%s</option>';
                    echo sprintf($html, $selected, $row['id'], $row['Name']);
                }
                # Ergebnis löschen
                $statement = null;

                ?>
            </select>

            <label for="Titel">Titel *</label>
            <input type="text" name="Titel" value="<?php echo $titel ?>" id="Titel" maxlength="150" required class="eingabe">

            <label for="Erscheinungsdatum">Erscheinungsdatum *</label>
            <input type="date" name="Erscheinungsdatum" value="<?php echo $erscheinungsdatum ?>" id="Erscheinungsdatum" value="" maxlength="10" required class="eingabe">
            
            <label for="Beschreibung">Beschreibung</label>
            <textarea name="Beschreibung" id="Beschreibung" maxlength="2000" class="eingabe"><?php echo $beschreibung ?></textarea>

            <button type="submit" name="Button" value="Speichern" class="button-link">Speichern</button>
    
        </form>

        </main>
        
    </body>
</html>