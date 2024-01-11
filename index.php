<?php

session_start();


function get_id_etu($login, $list_etu)
{
    foreach ($list_etu as $key => $value) {
        if ($login == $value->username) {
            $id_etu = $key;
            return $id_etu;
        }
    }
    return false;
}

function select_all_user($db, $login) {
    $req = "SELECT * FROM User WHERE `login` = :login";
    $arg[':login'] = $login;
    $db->prepare($req);
    return $res = $db->select($req,$arg);
}

function add_user($db, $etu) {

    $req = "INSERT INTO `User` (`login`, `first_name`, `name`, `email`, `id_role`) 
                VALUES (:login, :name, :first_name, :email, :id_role)";
    $args= [':login' =>  $etu['login']     ,
        ':name' =>  $etu['name']    ,
        ':first_name' => $etu['first_name'] ,
        ':email' => $etu['email'] ,
        ':id_role' =>  $etu['id_role']];
    $db->prepare($req);
    $db->instruct($req,$args);
}

function add_class($db, $group_name, $login) {
    //vérifier que la class existe :
    $test = "SELECT * FROM `Class` WHERE name_class = :name_class";
    $argtest[':name_class'] = $group_name;
    $db->prepare($test);
    $res = $db->select($test,$argtest);

    if (sizeof($res) == 0) {
        newClass($db, $group_name);
    }

    $req = " INSERT INTO User_Class (login, id_class)
             SELECT u.login, c.id_class
             FROM User AS u
             JOIN Class AS c ON c.name_class = :id_class
             WHERE u.login = :login";
    $args = [':login'=> $login,
        ':id_class' => $group_name];
    $db->prepare($req);
    $db->instruct($req,$args);
}

function newClass($db, $group_name) {
    $req = "INSERT INTO `Class` (name_class) VALUE (:name_class)";
    $arg[':name_class'] = $group_name;
    $db->prepare($req);
    $db->instruct($req,$arg);
}



// Full Hostname of your CAS Server
$cas_host = 'cas-uga.grenet.fr';
// Context of the CAS Server
$cas_context = '';
// Port of your CAS server. Normally for a https server it's 443
$cas_port = 443;
// url à charger apres l'authetification
$back_url = "https://asaed4.gremmi.fr";
// chargement de la librairie CAS : elle est dans les répertoires par défaut
require_once 'CAS/CAS.php';

phpCAS::setLogger();
phpCAS::setVerbose(true);
phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context, $back_url);
phpCAS::setNoCasServerValidation();
phpCAS::setLang(PHPCAS_LANG_FRENCH);



if( phpCAS::checkAuthentication()){
    // // at this step, the user has been authenticated by the CAS server
    // // and the user's login name can be read with phpCAS::getUser().

    $login = phpCAS::getUser();
 //   var_dump($login);
    require_once $_SERVER['DOCUMENT_ROOT'] . '/api/bd.php';

    $db = new BDHandler();

    $res = select_all_user($db, $login);

    if (sizeof($res) === 1) {
        echo "tu existes !!!!!!";
        var_dump($res);
        $_SESSION['login'] = $res[0]['login'];
        $_SESSION['first_name'] = $res[0]['first_name'];
        $_SESSION['name'] = $res[0]['name'];
        $_SESSION['email'] = $res[0]['email'];
        $_SESSION['id_role'] = $res[0]['id_role'];
        $_SESSION['id_class'] = $res[0]['id_class'];
        header('Location: https://asaed4.gremmi.fr/view/reservation/homeAdmin.php?login=' . urlencode($_SESSION['login']));
    }
    else {
        echo "tu n'existes pas mon gaté <br>";
        $id_etu = null;
        // vérifier que le login existe dans l'api des étudiants de l'iut
        $list_etu = json_decode(file_get_contents('https://iut1-mmi-moodle.univ-grenoble-alpes.fr/webservice/rest/server.php?wstoken=ba545e95bb07afa2256e1dcaa47c07a5&moodlewsrestformat=json&wsfunction=core_enrol_get_enrolled_users&courseid=412&options[0][name]=userfields&options[0][value]=groups&options[1][name]=userfields&options[1][value]=roles&options[2][name]=userfields&options[2][value]=username&options[3][name]=userfields&options[3][value]=email'));
        $test = get_id_etu($login, $list_etu);

        if (get_id_etu($login, $list_etu) !== false) {
            echo "tu as le droit !";
            $id_etu = get_id_etu($login, $list_etu);
            var_dump($id_etu);
            $etu_infos = $list_etu[$id_etu];
            echo "<br>";
            var_dump($etu_infos->groups);
            echo "<br>";
            $etu_log = $etu_infos->username;
            $fullname = explode(",",$etu_infos->fullname);
            $etu_finame = $fullname[1];
            $etu_name = $fullname[0];
            $etu_email = $etu_infos->email;
            if ($etu_infos->roles[0]->shortname === "editingteacher") {
                $id_role = 3; // == enseignant
            }
            else {
                $id_role = 4; // == student
            }

            $etu = ['login' => $etu_log,
                'first_name' => $etu_finame,
                'name' => $etu_name,
                'email' => $etu_email,
                'id_role' => $id_role];
            add_user($db, $etu);

            $groups = $etu_infos->groups;
            // créer une table user_class
            // pour chaque $groups, associer l'étu a la class

         //   var_dump($groups);
            foreach ($groups as $value) {
                $group_name = explode(" ",$value->name);
                var_dump($group_name[1]);
                add_class($db, $group_name[1], $etu['login']);
            }
            echo "SALUT MON GATééé";

            header('Location: https://asaed4.gremmi.fr/view/reservation/homeAdmin.php?login=' . urlencode($_SESSION['login']));

        }
        else {
            echo "tu n'as pas le droit mon gaté^^";
        }

    }




    //vérifier si c'est la première connexion :





  //  header('Location: https://asaed4.gremmi.fr/home.php');
    // $attr = phpCAS::getAttributes();
    // les serveurs cas ne donne pas toujours d'attributs (cas-uga n'en donne pas)

} else {
    phpCAS::forceAuthentication();
}
