<?php
// Paramètres de connexion à la base de données
$hostname = 'https://asaed4.gremmi.fr/adminer.php';
$username = 'asaed4';
$password = 'PhooJ4ze';
$database = 'asaed4';

// Nom du fichier de sauvegarde avec la date actuelle
$backupFile = $_SERVER['DOCUMENT_ROOT'].'/backupDB/'.'db_backup_' . date('Y-m-d') . '.sql';

// Commande de sauvegarde
$command = "mysqldump --user=$username --password=$password $database > $backupFile";

// Exécution de la commande
exec($command, $output, $returnVar);

// Vérification si la sauvegarde a réussi
if ($returnVar === 0) {
    echo 'La sauvegarde a été effectuée avec succès.';
} else {
    echo 'Une erreur s\'est produite lors de la sauvegarde : ' . implode("\n", $output);
}

?>
