<?php
session_start();
$donneesSession = json_encode($_SESSION);
if (!$_SESSION['id_role']) {
    header('Location: ../../index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Fiche Model</title>
    <link rel="stylesheet" href="../../css/style.css" />
    <link rel="stylesheet" href="../../css/detail.css" />
</head>
<body>

<?php include '../commun_html/header.php'; ?>

<main class="detailmain">

    <div class="title">
        <h1 id="nameModele"></h1>
        <?php
        if ($_SESSION['id_role'] == 1){
            echo '<img id="changeName" class="modify" src="../../img/crayon-de-couleur.png">
    <div id="formName" style="display: none">
        <label for="newName">Nouvel nom : </label>
        <input placeholder="nouveau nom du modèle" name="newName" id="newName" required>
        <button id="validateName" class="button-main">valider</button>
    </div>';
        }
        ?>
    </div>

    <div class="infos">
        <h4>
            Description :
        </h4>
        <p id="desc"></p>
        <?php
        if ($_SESSION['id_role'] == 1){
            echo '<img id="changeDesc" class="modify" src="../../img/crayon-de-couleur.png">
        <div id="formDesc" style="display: none">
            <label for="newDesc">Nouvel état : </label>
            <input placeholder="description" name="newDesc" id="newDesc" required>
            <button id="validateDesc" class="button-main">valider</button>
        </div>';
        }
        ?>

    </div>


    <div>
        <table>
            <thead>
            <tr>
                <th>Id</th>
                <th>N°</th>
                <th>Description</th>
                <th>État</th>
                <th>Date d'ajout</th>
            </tr>
            </thead>
            <tbody id="stock">
            </tbody>
        </table>
    </div>

</main>

<?php include '../commun_html/footer.php'; ?>

<script src="../../api.js"></script>
<script src="./js/detail.js"></script>

</body>
</html>