<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Cart {
    use Controller;

    public function list($data){
        $wtab = [];
        $jtab = [];
        $req = "SELECT DISTINCT * FROM `Cart` ";

        if(sizeof($data) > 0) {
            if (isset($data['id_res'])) {
                $w = " id_res = :id_res ";
                $wtab = $this->addWHERE($wtab, ':id_res', $data['id_res'], $w);
            }
        }

        if(sizeof($data) > 0) {
            if (isset($data['id_material'])) {
                $w = " id_material = :id_material ";
                $wtab = $this->addWHERE($wtab, ':id_material', $data['id_material'], $w);
            }
        }

        $where = $this->formatWHERE($wtab);
        $req.= $this->formatJOIN($jtab);
        $req .= $where["req"];
        $args = $where["args"];
        $this->res['data'] = $this->api->list($req, $args);
        $this->res['msg'] = "List the carts.";
        $this->stop(true);
    }

    public function add($data) {
        if(!isset($data['id_material']) and !isset($data['id_room'])){
            $this->res['msg'] = 'You must reserve a material or a room (add)';
            $this->stop(false);
        }
        if(isset($data['id_material']) and isset($data['id_room'])){
            $this->res['msg'] = 'You must reserve a material OR a room (add)';
            $this->stop(false);
        }
        $this->isset($data, 'id_res', "id_res should be specified (add).");
        $this->isset($data, 'date_begin', "date_begin should be specified (add).");
        $this->isset($data, 'date_end', "date_end should be specified (add).");

        //Insert
        $args = [':id_res' => $data['id_res'], ':date_begin' => $data['date_begin'],':date_end' => $data['date_end']];
        if (isset($data['id_material'])){
            $args[':id_material'] = $data['id_material'];
            $this->api->add(<<<EOL
                INSERT INTO `Cart` (`id_res`, `date_begin`, `date_end`, `id_material`) VALUES (:id_res, :date_begin, :date_end, :id_material);
            EOL, $args);
        }
        if (isset($data['id_room'])){
            $args[':id_room'] = $data['id_room'];
            $this->api->add(<<<EOL
                INSERT INTO `Cart` (`id_res`, `date_begin`, `date_end`, `id_room`) VALUES (:id_res, :date_begin, :date_end, :id_room);
            EOL, $args);
        }
    }

    public function update($data) {
        $this->isset($data, 'id_res', "id_res should be specified (update).");
        if(!isset($data['id_material']) and !isset($data['id_room'])){
            $this->res['msg'] = 'A reservation should be linked to an id_material or an id_room (update)';
            $this->stop(false);
        }
        if(isset($data['id_material']) and isset($data['id_room'])){
            $this->res['msg'] = 'You must reserve a material OR a room (update)';
            $this->stop(false);
        }

        $stab = [];
        $req = " UPDATE `Cart` ";

        if (isset($data['id_material'])){
            if (isset($data['date_return'])){
                $s = " date_return = :date_return ";
                $stab = $this->addSET($stab, ':date_return', $data['date_return'], $s);
            }
            if (isset($data['date_begin'])){
                $args[':date_begin'] = $data['date_begin'];
                $s = " date_begin = :date_begin ";
                $stab = $this->addSET($stab, ':date_begin', $data['date_begin'], $s);
            }
            if (isset($data['date_end'])) {
                $args[':date_end'] = $data['date_end'];
                $s = " date_end = :date_end ";
                $stab = $this->addSET($stab, ':date_end', $data['date_end'], $s);
            }
            $set = $this->formatSET($stab);
            $args = $set["args"];
            $args[':id_material'] = $data['id_material'];
            $args[':id_res'] = $data['id_res'];
            $req .= $set["req"];
            $req .= " WHERE id_material = :id_material AND id_res = :id_res";
        }
        if (isset($data['id_room'])){
            if (isset($data['date_return'])){
                $s = " date_return = :date_return ";
                $stab = $this->addSET($stab, ':date_return', $data['date_return'], $s);
            }
            if (isset($data['date_begin'])){
                $args[':date_begin'] = $data['date_begin'];
                $s = " date_begin = :date_begin ";
                $stab = $this->addSET($stab, ':date_begin', $data['date_begin'], $s);
            }
            if (isset($data['date_end'])) {
                $args[':date_end'] = $data['date_end'];
                $s = " date_end = :date_end ";
                $stab = $this->addSET($stab, ':date_end', $data['date_end'], $s);
            }
            $set = $this->formatSET($stab);
            $args = $set["args"];
            $args[':id_res'] = $data['id_res'];
            $args[':id_room'] = $data['id_room'];
            $req .= $set["req"];
            $req .= " WHERE id_res = :id_res AND id_room = :id_room";
        }

        $this->api->update($req, $args);
        $this->res['msg'] = "Element of reservation '{$data['id_res']}' updated.";
        $this->stop(true);
    }

    public function delete($data) {
        $this->isset($data, 'id_res', "id_res should be specified (delete).");
        if(!isset($data['id_material']) and !isset($data['id_room'])){
            $this->res['msg'] = 'You must reserve a material or a room (delete)';
            $this->stop(false);
        }
        if(isset($data['id_material']) and isset($data['id_room'])){
            $this->res['msg'] = 'You must reserve a material OR a room (delete)';
            $this->stop(false);
        }

        $args[':id_res'] = $data['id_res'];

        if (isset($data['id_material'])){
            $args[':id_material'] = $data['id_material'];
            $this->api->delete(<<<EOL
                DELETE FROM `Cart` 
                       WHERE `id_material` = :id_material AND `id_res` = :id_res;
            EOL, $args);
        }
        if (isset($data['id_room'])){
            $args[':id_room'] = $data['id_room'];
            $this->api->update(<<<EOL
                DELETE FROM `Cart` 
                WHERE `id_res` = :id_res AND `id_room` = :id_room;
            EOL, $args);
        }

        $this->res['msg'] = "element of cart deleted.";
        $this->stop(false);
    }
}
?>
