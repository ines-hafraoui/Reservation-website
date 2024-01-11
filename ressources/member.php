<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Member {
    use Controller;

    public function list($data){

        $this->isset($data, 'id_res', "id_res should be specified (select).");

        $args = [':id_res' => $data['id_res']];

        $req = "SELECT login FROM `Member` WHERE id_res = :id_res";

        // attention `lala` guillemets penchees pour les noms de table et col en SQL ("lala" guillemets double enSQLite)
        $this->res['data'] = $this->api->list($req, $args);
        $this->res['msg'] = "List all member from the reservation '{$data['id_res']}' .";
        $this->stop(true);

    }

    public function add($data) {
        $this->isset($data, 'id_res', "id_res should be specified (add).");
        $this->isset($data, 'login', "login should be specified (add).");

        $args = [':id_res' => $data['id_res'], ':login' => $data['login']];

        $this->api->add(<<<EOL
                INSERT INTO `Member` (`id_res`,`login`) VALUES (:id_res,:login);
            EOL, $args);

        $this->res['msg'] = "Member '{$data['login']}' has been add to the reservation '{$data['id_res']}'.";
        $this->stop(true);

    }

    public function update($data) {
        //pas besoin d'update pour la table member
    }

    public function delete($data) {
        $this->isset($data, 'id_res', "id_res should be specified (delete).");
        $this->isset($data, 'login', "login should be specified (delete).");

        $args = [':id_res' => $data['id_res'], ':login' => $data['login']];


        $this->api->delete(<<<EOL
                DELETE FROM `Member` 
                       WHERE `id_res` = :id_res AND `login` = :login;
            EOL, $args);

        $this->res['msg'] = "Member deleted.";
        $this->stop(false);
    }
}
?>
