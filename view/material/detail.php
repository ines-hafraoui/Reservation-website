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
    <title>Fiche Materiel</title>
    <link rel="stylesheet" href="../../css/style.css" />
    <link rel="stylesheet" href="../../css/detail.css" />
</head>
<body>

<?php include '../commun_html/header.php'; ?>

<main class="detailmain">

    <div class="title">
        <h1 id="nameModele"></h1> <h1 id="numMaterial" class="inline"></h1>
        <div class="desc">
            <h2 id="desc"></h2>
            <?php
            if ($_SESSION['id_role'] == 1){
                echo '<img id="changeDesc" class="modify" src="../../img/crayon-de-couleur.png">
            <div id="formDesc" style="display: none">
                <label for="newDesc">Nouvelle description : </label>
                <input placeholder="description" name="newDesc" id="newDesc" required>
                <button id="validateDesc" class="button-main">valider</button>
            </div>';
            }
            ?>

        </div>
    </div>


    <div class="infos">
        <h4>
            Ajouté le :
        </h4>
        <p id="ajout" class="text"></p>
        <?php
        if ($_SESSION['id_role'] == 1){
            echo '<img id="changeDateAdd" class="modify" src="../../img/crayon-de-couleur.png">
        <div id="formDateAdd" style="display: none">
            <label for="dateAdd">Nouvelle date : </label>
            <input placeholder="YYYY-MM-JJ" pattern="\d{4}-\d{2}-\d{2}" name="dateAdd" id="dateAdd" required>
            <button id="validateDateAdd" class="button-main">valider</button>
        </div>';
        }
        ?>

        <h4>
            Statut :
        </h4>
        <p id="statut" class="text"></p>
        <h4>
            État :
        </h4>
        <p id="etat" class="text"></p>
        <?php
        if ($_SESSION['id_role'] == 1){
            echo '<img id="changeEtat" class="modify" src="../../img/crayon-de-couleur.png">
        <div id="formEtat" style="display: none">
            <label for="state">Nouvel état : </label>
            <select id="newEtat" name="state">
                <option value="repair">En réparation</option>
                <option value="obsolete">Obsolète</option>
                <option value="room">Dans une salle</option>
                <option value="stock">En stock</option>
            </select>
            <button id="validateEtat" class="button-main">valider</button>
        </div>
        <div id="formRoom" style="display: none">
            <label for="salle">Nouvelle salle : </label>
            <select id="newRoom" name="salle">
            </select>
            <button id="validateRoom" class="button-main">valider</button>
        </div>';
        }
        ?>

        <div id="addPrblm">
            <h4>
                Problèmes :
            </h4>
            <?php
            if ($_SESSION['id_role'] == 1){
                echo '<img id="changePrblm" class="modify" src="../../img/Plus-icon.png">
        </div>
        <div id="formPrblm" style="display: none">
            <label for="prblm">Ajouter un problème : </label>
            <textarea placeholder="décrire le problème (concernant le matériel uniquement)" name="prblm" id="newPrblm" required></textarea>
            <button id="validatePrblm" class="button-main">valider</button>
        </div>';
            } else{
                echo '</div>';
            }
            ?>

        <ul id="prblm"></ul>
    </div>



    <div>
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