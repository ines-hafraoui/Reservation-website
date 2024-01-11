<!DOCTYPE html>
<?php
session_start();
$donneesSession = json_encode($_SESSION);
if (!$_SESSION['id_role']) {
    header('Location: ../../index.php');
}
//if ($_SESSION["id_role"]!= 1 OR $_SESSION["id_role"]!= 2 ){
    //header('Location: ../homepage');
//}
?>
<p lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ajouter au magasin</title>
        <link rel="stylesheet" type="text/css" href="ajout.css">
        <link rel="stylesheet" type="text/css" href="../../css/style.css">
        <script src="../../api.js" defer></script>
        <script src="js/ajout.js" defer></script>
    </head>
    <body>
        <?php include '../commun_html/header.php'; ?>
        <main id="addcontent">
            <header class="tab">
                <button id="mat_button" data-tab="#material" class="tablinks active">Matériel</button>
                <button id="model_button" data-tab="#model" class="tablinks"> Modèle</button>
                <button id="room_button" data-tab="#room" class="tablinks"> Salle</button>
            </header>

            <section id="material" class="tabcontent">
                <h2>Ajout Matériel</h2>
            </section>

            <section id="model" class="tabcontent hidden">
                <h2>Ajout Modèle</h2>
            </section>

            <section id="room" class="tabcontent hidden">
                <h2>Ajout Salle</h2
            </section>
        </main>

        <?php include '../commun_html/footer.php'; ?>
    </body>
</html>
