<?php
session_start();
if ($_SESSION['id_role'] === 1 || $_SESSION['id_role'] === 2) {
    header('Location: /view/reservation/homeAdmin.php');
}
elseif ($_SESSION['id_role'] === 3 || $_SESSION['id_role'] === 4) {
    header("Location: /view/reservation/homeEtu.php?login=" . urlencode($_SESSION['login']));
}
else {
    header('Location: ../../index.php');
}
?>
