<?php
session_start();
$donneesSession = json_encode($_SESSION);
if (!$_SESSION['id_role']) {
    header('Location: ../../index.php');
}
include '../commun_html/header.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your Page Title</title>
    <!-- Additional meta tags, CSS stylesheets, or JavaScript files can be included here -->
    <link rel="stylesheet" type="text/css" href="../../css/flash_messages.css">
    <link rel="stylesheet" type="text/css" href="list.css">
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
</head>
<body>
<!-- Your page content goes here -->
<nav class="material-menu">
    <ul>
        <li>Éclairage</li>
        <li>Prise de vue</li>
        <li>Prise de son</li>
        <li>Accessoires</li>
        <li>Support</li>
    </ul>
</nav>
<button onclick="deleteReservation()"  id="delete-res" class="button-main">Annuler ma reservation</button>
<button id="validate-reservation"  class="button-main">Valider ma reservation</button>
<section class="input-res-container">
    <!--<h1>Réserver du matériel</h1>
    <form method="POST" action="">
        <label for="dateBegin">Date de départ : </label>
        <input type="date" id="dateBegin" name="dateBegin" required><br>

        <label for="dateEnd">Date de retour : </label>
        <input type="date" id="dateEnd" name="dateEnd" required><br>

        <input type="submit" value="Envoyer">
    </form>-->
    <input id="datepicker">
    <button id="datepicker-validate"  class="button-main">Valider ce materiel</button>
</section>
<section class="material-list">
    <div class="material-list-container">
    </div>
</section>
<script>
    var donneesSession = <?php echo $donneesSession; ?>;
</script>

<?php include '../commun_html/footer.php'?>
<script src="https://cdn.jsdelivr.net/npm/@easepick/bundle@1.2.1/dist/index.umd.min.js"></script>
<script src="../../api.js"></script>
<script src="../../js/flash_messages.js"></script>
<script src="./js/datepicker.js"></script>
<script src="./js/material_list.js"></script>

</body>
</html>