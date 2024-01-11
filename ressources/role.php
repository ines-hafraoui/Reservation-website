<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Role {
    use Controller;

    public function list($data) {
        $args = [];
        $req = "SELECT * FROM `Role`";

        if(isset($data['id_role'])){
            $args[':id_role'] = $data['id_role'];
            $req .= " WHERE id_role = :id_role";
        }

        elseif(isset($data['name_role'])){
            $args[':name_role'] = $data['name_role'];
            $req .= " WHERE name_role = :name_role";
        }

        // attention `lala` guillemets penchees pour les noms de table et col en SQL ("lala" guillemets double enSQLite)
        $this->res['data'] = $this->api->list($req, $args);
        $this->res['msg'] = "List all roles.";
        $this->stop(true);
    }

    public function add($data) {
        $this->isset($data, 'name_role', "name_role should be specified (add).");

        $args[':name_role'] = $data['name_role'];

        $this->api->add(<<<EOL
                INSERT INTO `Role` (`name_role`) VALUES (:name_role);
            EOL, $args);

        $this->res['msg'] = "Role '{$data['name_role']}' added.";
        $this->stop(true);
    }

    public function update($data) {
        $this->isset($data, 'id_role', "id_role should be specified (update).");
        $this->isnum($data, 'id_role', "id_role should be numeric (update).");
        $this->isset($data, 'name_role', "name_role should be specified (update).");

        $args[':id_role'] = $data['id_role'];
        $args[':name_role'] = $data['name_role'];

        $this->api->update(<<<EOL
                UPDATE `Role`
                SET `name_room` = :name_room
                WHERE `id_role` = :id_role;
            EOL, $args);

        $this->res['msg'] = "Role '{$data['name_role']}' updated.";
        $this->stop(true);
    }

    public function delete($data) {
        $this->isset($data, 'id_role', "id_role should be specified (delete).");
        $this->isnum($data, 'id_role', "id_class should be numeric (delete).");

        $args[':id_role'] = $data['id_role'];


        $this->api->delete(<<<EOL
                DELETE FROM `Role` WHERE `id_role` = :id_role;
            EOL, $args);

        $this->res['msg'] = "Role deleted.";
        $this->stop(false);
    }
}
?>
