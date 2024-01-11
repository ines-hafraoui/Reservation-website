<?php
session_start();
if (!$_SESSION['id_role']) {
    header('Location: ../../index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reservations</title>
    <link rel="stylesheet" href="../../css/style.css" />
</head>
<body>
<?php include '../commun_html/header.php'; ?>
<main class="detailmain">
    <div class="menuEtu">
    <div class="asideMenuEtuHome">
        <h2>Faire une réservation :</h2>
        <a href="../material/list.php">Réserver du matériel</a>
        <a href="../room/list.php">Réserver une salle</a>
        <a href="../material/list.php">Cours</a>
    </div>
<div class="reservationEtuContainer">
    <h1 class="titlePage"></h1>
    <p>Mes Réservations : </p>
    <div class="reservationListContainer"></div>
</div></div>
</main>
<?php include '../commun_html/footer.php'; ?>
</body>
<script src="/api.js"></script>
<script src="./js/reservation.js"></script>
<script src="./js/reservationEtu.js"></script>
</html>
