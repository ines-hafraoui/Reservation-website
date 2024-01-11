<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your Page Title</title>
    <!-- Additional meta tags, CSS stylesheets, or JavaScript files can be included here -->
</head>
<body>
<button id="init-reservation"><a href="../material/list.php">Créer une réservation</a></button>
<?php
session_start();
if (!$_SESSION['id_role']) {
    header('Location: ../../index.php');
}
?>
</body>
</html>