<?php
session_start();
$donneesSession = json_encode($_SESSION);
$_SESSION['mode'] = 'etu';
//var_dump($donneesSession);

if ($_SESSION['id_role'] == 1 or $_SESSION['id_role'] == 2){
    echo '<header class="commonheader">
<div class="wrapper">
    
    <div class="logo elmt">
        <a href="../reservation/homeAdmin.php">
            <img src="../../img/logo.png" style="height: 100%">
        </a>
    </div>

    <div class="partMenu elmt">
        <ul class="menu">
            <li><a href="../reservation/list.php">Réservations</a></li>
            <li><a href="../material/list.php">Matériels</a></li>
            <li><a href="../user/">Utilisateurs</a></li>
            <li><a href="../add/">Ajouter</a></li>
        </ul>
    </div>

    <div class="login elmt">' .
        $_SESSION['login']  .
        '</div>
</div>
</header>';
}

else if ($_SESSION['id_role'] == 3) {
    echo '<header class="commonheader">
<div class="wrapper">
    
    <div class="logo elmt">
        <a href="../reservation/homeAdmin.php">
            <img src="../../img/logo.png" style="height: 100%">
        </a>
    </div>

    <div class="partMenu elmt">
        <ul class="menu">
            <li><a href="../material/list.php">Réserver du matériel</a></li>
            <li><a href="../room/list.php">Réserver une salles</a></li>
        </ul>
    </div>

    <div class="login elmt">' .
        $_SESSION['login']  .
        '</div>

</div>
</header>';
}

else {
    echo '<header class="commonheader">
<div class="wrapper">

    <div class="logo elmt">
        <a href="../reservation/homeAdmin.php">
            <img src="../../img/logo.png" style="height: 100%">
        </a>
    </div>

    <div class="partMenu elmt">
        <ul class="menu">
            <li><a href="../material/list.php">Réserver du matériel</a></li>
            <li><a href="../room/list.php">Réserver une salle</a></li>
            <li class="user-res-class"><a href="../material/list.php">Cours</a></li>
        </ul>
    </div>

    <div class="login elmt">' .
        $_SESSION['login']  .
        '</div>

</div>
</header>';
}
?>

