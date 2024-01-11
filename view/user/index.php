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
        <title>Liste des utilisateurs</title>
        <link rel="stylesheet" type="text/css" href="../../css/style.css">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
        <script src="../../api.js" defer></script>
        <script>
            let donneesSession = <?php echo $donneesSession; ?>;
        </script>
        <script src="js/list.js" defer></script>
    </head>
    <body>

        <?php include '../commun_html/header.php'; ?>

        <main id="user-list">
            <header>
                <h2>Liste des utilisateurs :</h2>
                <section class="scontainer">
                    <div class="search-container">
                        <input type="text" name="search" placeholder="Rechercher un utilisateur..."  id="user-search" class="search-input">
                        <a href="#" class="search-btn">
                            <i class="fas fa-search"></i>
                        </a>
                    </div>
                </section>
            </header>
            <aside><!-- c'est là que seront insérés les rôles -->
                <h3>Filtrer par rôle :</h3>
            </aside>
            <ul class="userdisplay"> <!-- c'est là que seront insérés les utilisateurs -->
            </ul>
        </main>

        <?php include '../commun_html/footer.php'; ?>
    </body>
