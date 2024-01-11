<?php
session_start();
if ($_SESSION['id_role'] === 3 || $_SESSION['id_role'] === 4) {
    header("Location: /view/reservation/homeEtu.php?login=" . urlencode($_SESSION['login']));
}
elseif (!$_SESSION['id_role']) {
    header('Location: ../../index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reservations</title>
    <link rel="stylesheet" href="../../css/style.css" />
</head>
<main>
<?php include '../commun_html/header.php';
    echo '<main class="detailmain"><a href="homeEtu.php?login=' . urlencode($_SESSION['login']) . '">Page des étudiants</a>';
?>


<div class="reservation-body">
    <h1 class="titlePage">Réservation</h1>
    <div class="rerservation-a-venir">

    </div>
    <a href="list.php">Historique des réservations</a>
</div>
</main>
<?php include '../commun_html/footer.php'; ?>
</body>
<script src="/api.js"></script>
<script src="./js/reservation.js"></script>
<script src="./js/reservationHome.js"></script>

</html>
