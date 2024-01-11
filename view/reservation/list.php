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
<body>
<?php include '../commun_html/header.php'; ?>
<main class="detailmain">
<div class="reservation-body">
    <h1 class="titlePage">Historique des réservations</h1>
    <div class="divSortResByDate">
        <input type="button" value="Tri Date" name="sortResByDate" id="sortResByDate">
    </div>
    <div id="searchBarRes">
        <input type="text" placeholder="Écrire pour rechercher">
    </div>
    <div class="divTableauHistoriqueRes">

    </div>
</div>
</main>
<?php include '../commun_html/footer.php'; ?>
</body>
<script src="/api.js"></script>
<script src="./js/reservation.js"></script>
<script src="./js/reservationList.js"></script>
</html>
