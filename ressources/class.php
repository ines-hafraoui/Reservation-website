<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

class Group {
    use Controller;

    public function list($data) {
        $args = [];
        $req = "SELECT * FROM `Class`";

        if(isset($data['id_class'])){
            $args[':id'] = $data['id_class'];
            $req .= " WHERE id_class = :id";
        }

        elseif(isset($data['name_class'])){
            $args[':name'] = $data['name_class'];
            $req .= " WHERE name_class = :name";
        }

        elseif(isset($data['semester'])){
            $args[':semester'] = $data['semester'];
            $req .= " WHERE name_class LIKE CONCAT('_', :semester, '%')";
        }

        // attention `lala` guillemets penchees pour les noms de table et col en SQL ("lala" guillemets double enSQLite)
        $this->res['data'] = $this->api->list($req, $args);
        $this->res['msg'] = "List all classes.";
        $this->stop(true);
    }

    public function add($data) {
        $this->isset($data, 'name_class', "name_class should be specified (add).");

        $args[':name_class'] = $data['name_class'];

        $this->api->add(<<<EOL
                INSERT INTO `Class` (`name_class`) VALUES (:name_class);
            EOL, $args);

        $this->res['msg'] = "Class '{$data['name_class']}' added.";
        var_dump($this->res['msg']);
        $this->stop(true);
    }

    public function update($data) {
        $this->isset($data, 'id_class', "id_class should be specified (update).");
//        $this->isnum($data, 'id_class', "id_class should be numeric (update).");
        $this->isset($data, 'name_class', "name_class should be specified (update).");

        $args[':id_class'] = $data['id_class'];
        $args[':name_class'] = $data['name_class'];

        $this->api->update(<<<EOL
                UPDATE `Class`
                SET `name_class` = :name_class
                WHERE `id_class` = :id;
            EOL, $args);

        $this->res['msg'] = "Class '{$data['name_class']}' updated.";
        $this->stop(true);
    }

    public function delete($data) {
        $this->isset($data, 'id_class', "id_class should be specified (delete).");
        $this->isnum($data, 'id_class', "id_class should be numeric (delete).");

        $args[':id_class'] = $data['id_class'];


        $this->api->delete(<<<EOL
                DELETE FROM `Class` WHERE `id_class` = :id_class;
            EOL, $args);

        $this->res['msg'] = "Class deleted.";
        $this->stop(false);
    }
}
?>
