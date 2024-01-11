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
    <title>Fiche Salle</title>
    <link rel="stylesheet" href="../../css/style.css" />
    <link rel="stylesheet" href="../../css/detail.css" />
</head>
<body>

<?php include '../commun_html/header.php'; ?>

<main class="detailmain">

    <div class="title">
        <h1 id="nameRoom"></h1>
        <?php
        if ($_SESSION['id_role'] == 1){
            echo '<img id="changeName" class="modify" src="../../img/crayon-de-couleur.png">
    <div id="formName" style="display: none">
        <label for="newName">Nouveau nom : </label>
        <input placeholder="nouveau nom de la salle" name="newName" id="newName" required>
        <button id="validateName" class="button-main">valider</button>
    </div>';
        }
        ?>
    </div>

    <h3>
        Statut :
    </h3>
    <p id="statut"></p>


    <div class="lesTab">
        <h3 class="title">Materiel présent dans la salle</h3>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Modèle</th>
                <th>N°</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody id="listMat">
            </tbody>
        </table>
        <?php
        if ($_SESSION['id_role'] == 1){
            echo '<div class="changeMat">
<button id="addMat" class="button-main">Ajouter du matériel</button>
    <div id="formAdd" style="display: none">
        <label for="amaterial">Nouveau materiel : </label>
        <select id="newMat" name="amaterial">
        </select>
        <button id="validateAddMat" class="button-main">valider</button>
    </div>
    <button id="deleteMat" class="button-main">Enlever du matériel</button>
    <div id="formDelete" style="display: none">
        <label for="dmaterial">Materiel enlevé : </label>
        <select id="oldMat" name="dmaterial">
        </select>
        <button id="validateDeleteMat" class="button-main">valider</button>
    </div>
    </div>';
        }
        ?>
    </div>


    <div class="lesTab">
        <h3 class="title">Historique des réservations</h3>
        <table>
            <thead>
            <tr>
                <th>id_res</th>
                <th>login</th>
                <th>date début</th>
                <th>date fin</th>
                <th>date de retour</th>
            </tr>
            </thead>
            <tbody id="historique">
            </tbody>
        </table>
    </div>

</main>

<?php include '../commun_html/footer.php'; ?>

<script src="../../api.js"></script>
<script src="./js/detail.js"></script>

</body>
</html>