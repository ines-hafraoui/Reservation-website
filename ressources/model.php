<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Model {
    use Controller;

    public function list($data) {
        $wtab = [];
        $req = "SELECT * FROM `Model`";


        if(sizeof($data) > 0){
            if (isset($data['id_model'])){
                $w = " `id_model` = :id_model ";
                $wtab = $this->addWHERE($wtab, ':id_model', $data['id_model'], $w);
            }
            if (isset($data['name_model'])) {
                $w = " `name_model` = :name_model ";
                $wtab = $this->addWHERE($wtab, ':name_model', $data['name_model'], $w);
            }
            if (isset($data['id_type'])) {
                $w = " `id_type` = :id_type ";
                $wtab = $this->addWHERE($wtab, ':id_type', $data['id_type'], $w);
            }
        }

        $where = $this->formatWHERE($wtab);
        $req .= $where["req"];

        $this->res['data'] = $this->api->list($req, $where["args"]);
        $this->res['msg'] = "List models.";
        $this->stop(true);
    }

    public function add($data) {
        $this->isset($data, 'name_model', "id_model should be specified (add).");
        $this->isset($data, 'id_type', "id_type should be specified (add).");
        $this->isset($data, 'desc_model', "desc should be specified (add).");
        $this->isset($data, 'img', "img should be specified (add).");

        $args = [':name_model' => $data['name_model'], ':id_type' => $data['id_type'], ':desc_model' => $data['desc_model'], ':img' => $data['img']];

        $this->api->add(<<<EOL
                INSERT INTO `Model` (`name_model`, `id_type`, `description`, `image`)
                VALUES (:name_model, :id_type, :desc_model, :img)
            EOL, $args);

        $this->res['msg'] = "Model '{$data['name_model']}' added.";
        $this->stop(true);
    }

    public function update($data) {
        $this->isset($data, 'id_model', "Model id should be specified (update).");
        $this->isnum($data, 'id_model', "Model id should be numeric (update).");

        $stab = [];
        $req = " UPDATE `Model` ";

        if(isset($data['name_model'])){
            $s = " name_model = :name_model ";
            $stab = $this->addSET($stab, ':obsolete', $data['obsolete'], $s);
        }
        if(isset($data['id_type'])){
            $s = " id_type = :id_type ";
            $stab = $this->addSET($stab, ':id_type', $data['id_type'], $s);
        }
        if(isset($data['desc_model'])){
            $s = " desc_model = :desc_model ";
            $stab = $this->addSET($stab, ':desc_model', $data['desc_model'], $s);
        }
        if(isset($data['img'])){
            $s = " img = :img ";
            $stab = $this->addSET($stab, ':img', $data['img'], $s);
        }

        $set = $this->formatSET($stab);
        $args = $set["args"];
        $args[':id_model'] = $data['id_model'];
        $req .= $set["req"];
        $req .= " WHERE id_model = :id_model ";
        //var_dump($stab);

        $this->api->update($req, $args);
        $this->res['msg'] = "Model updated.";
        $this->stop(true);
    }

    public function delete($data) {
        $this->isset($data, 'id_model', "Model id should be specified (delete).");
        $this->isnum($data, 'id_model', "Model id should be numeric (delete).");

        $args[':id_model'] = $data['id_model'];


        $this->api->delete(<<<EOL
                DELETE FROM `Model` WHERE `id_model` = :id_model;
            EOL, $args);

        $this->res['msg'] = "Model deleted.";
        $this->stop(false);
    }
}
?>
