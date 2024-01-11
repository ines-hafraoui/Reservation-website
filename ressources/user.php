<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class User {
    use Controller;

    public function list($data) {
        $wtab = [];
        $jtab = [];
        $req = "SELECT * FROM `User`";

        //JOIN User_Class ON User.login = User_Class.login
        //JOIN Class ON User_Class.id_class = Class.id_class


        if(sizeof($data) > 0){
            if (isset($data['login']) && !isset($data['allclass'])){
                $w = " `login` = :login ";
                $wtab = $this->addWHERE($wtab, ':login', $data['login'], $w);
            }
            if (isset($data['name'])) {
                $w = " `name` = :name ";
                $wtab = $this->addWHERE($wtab, ':name', $data['name'], $w);
            }
            if (isset($data['first_name'])) {
                $w = " `first_name` = :first_name ";
                $wtab = $this->addWHERE($wtab, ':first_name', $data['first_name'], $w);
            }
            if (isset($data['id_role'])) {
                $w = " `id_role` = :id_role ";
                $wtab = $this->addWHERE($wtab, ':id_role', $data['id_role'], $w);
            }
            if (isset($data['name_class'])) {
                $j = " JOIN User_Class ON User_Class.login = User.login ";
                $w = " Class.name_class = :name_class ";
                $jtab = $this->addJOIN($jtab, $j);
                $j = " JOIN Class ON User_Class.id_class = Class.id_class ";
                $jtab = $this->addJOIN($jtab, $j);
                $wtab = $this->addWHERE($wtab, ':name_class', $data['name_class'], $w);
            }
            if (isset($data['allclass']) && $data['allclass'] == true && isset($data['login'])) {
                $req = "SELECT DISTINCT Class.name_class, Class.id_class FROM User";
                $j = "JOIN User_Class ON User.login = User_Class.login ";
                $jtab = $this->addJOIN($jtab, $j);
                $j = "JOIN Class ON User_Class.id_class = Class.id_class ";
                $jtab = $this->addJOIN($jtab, $j);
                $w = "User.login = :login ";
                $wtab = $this->addWHERE($wtab, ':login', $data['login'], $w);
            }
        }

        $where = $this->formatWHERE($wtab);
        $req .= $this->formatJOIN($jtab);
        $req .= $where["req"];
        $this->res['data'] = $this->api->list($req, $where["args"]);
        $this->res['msg'] = "List the users.";
        $this->stop(true);
    }

    public function add($data) {
        $this->isset($data, 'login', "login should be specified (add).");
        $this->isset($data, 'name', "name should be specified (add).");
        $this->isset($data, 'first_name', "first_name should be specified (add).");
        $this->isset($data, 'email', "email should be specified (add).");
        $this->isset($data, 'id_role', "id_role should be specified (add).");
        $this->isset($data, 'id_class', "id_class should be specified (add).");


        $req = <<<EOL
                INSERT INTO `User` (`login`, `name`, `first_name`, `email`, `id_role`) 
                VALUES (:login, :name, :first_name, :email, :id_role);
                INSERT INTO `User_Class` (`login`, `id_class`) 
                VALUES (:login, :id_class);
EOL;

        $args = [':login' => $data['login'],
            ':name' => $data['name'],
            ':first_name' => $data['first_name'],
            ':email' => $data['email'],
            ':id_role' => $data['id_role'],
            ':id_class' => $data['id_class']];

        var_dump($args);

        $this->api->add($req, $args );
        $this->res['msg'] = "User '{$data['login']}' added.";
        $this->stop(true);
    }

    public function update($data) {
        $this->isset($data, 'login', "Login should be specified (update).");

        if (sizeof($data) < 2) {
            $this->res['msg'] = "not enough args";
            $this->stop(false);
        }
        else {
            $stab = [];
            $jtab = [];
            $req = " UPDATE `User` ";

            if(isset($data['first_name'])){
                $s = " first_name = :first_name ";
                $stab = $this->addSET($stab, ':first_name', $data['first_name'], $s);
            }

            if(isset($data['name'])){
                $s = " name = :name ";
                $stab = $this->addSET($stab, ':name', $data['name'], $s);
            }

            if(isset($data['email'])){
                $s = " email = :email ";
                $stab = $this->addSET($stab, ':email', $data['email'], $s);
            }

            if(isset($data['id_role'])){
                $s = " id_role = :id_role ";
                $stab = $this->addSET($stab, ':id_role', $data['id_role'], $s);
            }

            $set = $this->formatSET($stab);
            $args = $set["args"];
            $args[':login'] = $data['login'];
            $req .= $this->formatJOIN($jtab);
            $req .= $set["req"];
            $req .= " WHERE `User`.login = :login ";

            $this->api->update($req, $args);
            $this->res['msg'] = "User '{$data['login']}' updated";
            $this->stop(true);
        }
    }

    public function delete($data) {
        $this->isset($data, 'login', "Login should be specified (delete).");

        $req = <<<EOL
                DELETE FROM `User` WHERE `login` = :login;
EOL;

        $args = [':login' => $data['login']];

        $this->api->delete($req, $args );
        $this->res['msg'] = "User '{$data['login']}' deleted.";
        $this->stop(true);
    }
}
