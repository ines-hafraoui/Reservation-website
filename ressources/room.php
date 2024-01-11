<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Room {
    use Controller;

    public function list($data) {
        $args = [];
        $wtab = [];
        $jtab = [];
        $req = "SELECT * FROM `Room`";

        if(isset($data['id_room'])){
            $args[':id'] = $data['id_room'];
            $req .= " WHERE id_room = :id";
        }

        elseif(isset($data['name_room'])){
            $args[':name'] = $data['name_room'];
            $req .= " WHERE name_room = :name";
        }

        elseif (isset($data['id_res'])){
            $args[':id_res'] = $data['id_res'];
            $req .= "JOIN Cart ON Room.id_room = Cart.id_room WHERE Cart.id_res = :id_res";
        }

        // attention `lala` guillemets penchees pour les noms de table et col en SQL ("lala" guillemets double enSQLite)
        $this->res['data'] = $this->api->list($req, $args);
        $this->res['msg'] = "List all rooms.";
        $this->stop(true);
    }

    public function add($data) {
        $this->isset($data, 'name_room', "name_room should be specified (add).");

        $args[':name_room'] = $data['name_room'];

        $this->api->add(<<<EOL
                INSERT INTO `Room` (`name_room`) VALUES (:name_room);
            EOL, $args);

        $this->res['msg'] = "Room '{$data['name_room']}' added.";
        $this->stop(true);
    }

    public function update($data) {
        $this->isset($data, 'id_room', "id_room should be specified (update).");
        $this->isnum($data, 'id_room', "id_room should be numeric (update).");
        $this->isset($data, 'name_room', "name_room should be specified (update).");

        $args[':id_room'] = $data['id_room'];
        $args[':name_room'] = $data['name_room'];

        $this->api->update(<<<EOL
                UPDATE `Room`
                SET `name_room` = :name_room
                WHERE `id_room` = :id_room;
            EOL, $args);

        $this->res['msg'] = "Room '{$data['name_room']}' updated.";
        $this->stop(true);
    }

    public function delete($data) {
        $this->isset($data, 'id_room', "id_room should be specified (delete).");
        $this->isnum($data, 'id_room', "id_room should be numeric (delete).");

        $args[':id_room'] = $data['id_room'];


        $this->api->delete(<<<EOL
                DELETE FROM `Room` WHERE `id_room` = :id_room;
            EOL, $args);

        $this->res['msg'] = "Room deleted.";
        $this->stop(false);
    }
}
?>
