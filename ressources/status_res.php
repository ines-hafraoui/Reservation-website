<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Status_res {
    use Controller;

    public function list($data) {
        $args = [];
        $req = "SELECT * FROM `Status_res`";

        if(isset($data['id_status'])){
            $args[':id_status'] = $data['id_status'];
            $req .= " WHERE id_status = :id_status";
        }

        elseif(isset($data['name_status'])){
            $args[':name_status'] = $data['name_status'];
            $req .= " WHERE name_status = :name_status";
        }

        // attention `lala` guillemets penchees pour les noms de table et col en SQL ("lala" guillemets double enSQLite)
        $this->res['data'] = $this->api->list($req, $args);
        $this->res['msg'] = "List all status.";
        $this->stop(true);
    }

    public function add($data) {
        $this->isset($data, 'name_status', "name_status should be specified (add).");

        $args[':name_status'] = $data['name_status'];

        $this->api->add(<<<EOL
                INSERT INTO `Status_res` (`name_status`) VALUES (:name_status);
            EOL, $args);

        $this->res['msg'] = "Status '{$data['name_status']}' added.";
        $this->stop(true);
    }

    public function update($data) {
        $this->isset($data, 'id_status', "id_status should be specified (update).");
        $this->isnum($data, 'id_status', "id_status should be numeric (update).");
        $this->isset($data, 'name_status', "name_status should be specified (update).");

        $args[':id_status'] = $data['id_status'];
        $args[':name_status'] = $data['name_status'];

        $this->api->update(<<<EOL
                UPDATE `Status_res`
                SET `name_status` = :name_status
                WHERE `id_status` = :id_status;
            EOL, $args);

        $this->res['msg'] = "Role '{$data['name_status']}' updated.";
        $this->stop(true);
    }

    public function delete($data) {
        $this->isset($data, 'id_status', "id_status should be specified (delete).");
        $this->isnum($data, 'id_status', "id_status should be numeric (delete).");

        $args[':id_status'] = $data['id_status'];


        $this->api->delete(<<<EOL
                DELETE FROM `Status_res` WHERE `id_status` = :id_status;
            EOL, $args);

        $this->res['msg'] = "Role deleted.";
        $this->stop(false);
    }
}
?>
