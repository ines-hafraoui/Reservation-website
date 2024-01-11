<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class User_Class {
    use Controller;

    public function list($data) {

    }

    public function add($data) {
        $this->isset($data, 'login', "Login should be specified (add).");
        $this->isset($data, 'id_class', "class should be specified (add).");

        $req = <<<EOL
                INSERT INTO `User_Class` (`login`, `id_class`) 
                VALUES (:login, :id_class);
EOL;

        $args = [':login' => $data['login'],
            ':id_class' => $data['id_class']];

        $this->api->add($req, $args );
        $this->res['msg'] = "User_Class '{$data['login']}' added.";
        $this->stop(true);
    }

    public function update($data) {
        $this->isset($data, 'login', "Login should be specified (update).");
        $this->isset($data, 'id_class', "id_class should be specified (update).");

        if (sizeof($data) != 2) {
            $this->res['msg'] = "not enough args//too much args";
            $this->stop(false);
        }
        else {
            //$jtab = [];
            $stab = [];
            $req = " UPDATE `User_Class` ";

            if(isset($data['id_class'])){
           //     $j = " JOIN Class ON _Class.id_class = Class.id_class ";
           //     $jtab = $this->addJOIN($jtab, $j);
           //     $s = " User_Class.id_class = (
           //            SELECT id_class FROM Class
           //            WHERE name_class = :name_class
           //            ) ";
                  $s = " id_class = :id_class ";
                $stab = $this->addSET($stab, ':id_class', $data['id_class'], $s);

            }

            $set = $this->formatSET($stab);
            $args = $set["args"];
            $args[':login'] = $data['login'];
      //      $req .= $this->formatJOIN($jtab);
            $req .= $set["req"];
            $req .= " WHERE login = :login ";

            $this->api->update($req, $args);
            $this->res['msg'] = "User_Class '{$data['login']}' updated";
            $this->stop(true);
        }
//        $this->isset($data, 'id', "Ingredient id should be specified (update).");
//        $this->isnum($data, 'id', "Ingredient id should be numeric (update).");
//        $this->isset($data, 'name', "Ingredient name should be specified (update).");
//
//        $this->api->update(<<<EOL
//                UPDATE "Ingredient"
//                SET name = '{$data['name']}'
//                WHERE id = {$data['id']};
//            EOL);
//        $this->res['msg'] = "Ingredient '{$data['name']}' updated.";
//        $this->stop(true);
    }

    public function delete($data) {
        $this->isset($data, 'login', "Login should be specified (delete).");

        $req = <<<EOL
                DELETE FROM `User_Class` WHERE `login` = :login;
EOL;

        $args = [':login' => $data['login']];

        $this->api->delete($req, $args );
        $this->res['msg'] = "User_Class '{$data['login']}' deleted.";
        $this->stop(true);
    }
}
