<!DOCTYPE html>
<?php
session_start();
$donneesSession = json_encode($_SESSION);
if (!$_SESSION['id_role']) {
    header('Location: ../../index.php');
}
//if ($_SESSION["id_role"]!= 1 OR $_SESSION["id_role"]!= 2 ){
//    header('Location: ../homepage');
//}
?>
<p lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Détail de l'utilisateur</title>
        <link rel="stylesheet" type="text/css" href="../../css/style.css">
        <link rel="stylesheet" type="text/css" href="../../css/detail.css">
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="../../api.js" defer></script>
        <script>
            let donneesSession = <?php echo $donneesSession; ?>;
        </script>
        <script src="js/detail.js" defer></script>
    </head>
    <body>
        <?php include '../commun_html/header.php'; ?>

        <main id="user-detail" class="detailmain">
            <header id="title" class="title"></header>
            <section id="infos">
                <section id="user_role">
                    <section id="user_roleform"></section>
                </section>
            </section>
            <section id="problem">
                <section id="user_problemform"></section>
            </section>
            <section id="history">
            </section>
        </main>
        <?php include '../commun_html/footer.php'; ?>

    </body>

