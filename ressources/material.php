<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Material {
    use Controller;

    public function list($data) {
        $args = [];
        $jtab = [];
        $wtab = [];
        $req = "SELECT * FROM `Material`";
        $j = " JOIN `Model` ON Material.id_model = Model.id_model ";
        $jtab = $this->addJOIN($jtab, $j);
        $date_begin = NULL;

        if(sizeof($data) > 0){
            // Selects material by its id
            if(isset($data['id_material'])){
//                $args[':id_material'] = $data['id_material'];
                $j = " JOIN `Model` ON Material.id_model = Model.id_model ";
                $jtab = $this->addJOIN($jtab, $j);
                $w = " id_material = :id_material ";
                $wtab = $this->addWHERE($wtab, ':id_material', $data['id_material'], $w);
            }

            // Selects material that is obsolete(1) or not(0)
            if(isset($data['obsolete'])){
//                $args[':obsolete'] = $data['obsolete'];
                $w = " obsolete = :obsolete ";
                $wtab = $this->addWHERE($wtab, ':obsolete', $data['obsolete'], $w);
            }

            // Selects material that is in a specific number
            if(isset($data['number'])){
//                $args[':obsolete'] = $data['obsolete'];
                $w = " number = :number ";
                $wtab = $this->addWHERE($wtab, ':number', $data['number'], $w);
            }

            // Selects material that is in repair(1) or not in repair(0)
            if(isset($data['in_repair'])){
//                $args[':in_repair'] = $data['in_repair'];
                $w = " in_repair = :in_repair ";
                $wtab = $this->addWHERE($wtab, ':in_repair', $data['in_repair'], $w);
            }

            // Selects material that is a certain model
            if(isset($data['id_model'])){
                //$args[':id_model'] = $data['id_model'];
                $j = " JOIN `Model` ON Material.id_model = Model.id_model ";
                $w = " Model.id_model = :id_model ";
                $jtab = $this->addJOIN($jtab, $j);
                $wtab = $this->addWHERE($wtab, ':id_model', $data['id_model'], $w);
            }

            // Selects material that is in a specific room
            if(isset($data['id_room'])){
                //$args[':id_room'] = $data['id_room'];
                $j = " JOIN `Room` ON Material.id_room = Room.id_room ";
                $w = " Room.id_room = :id_room                  ";
                $jtab = $this->addJOIN($jtab, $j);
                $wtab = $this->addWHERE($wtab, ':id_room', $data['id_room'], $w);
            }

            // Selects material that is part of a category
            if(isset($data['id_type'])){
                $j = " JOIN `Model` ON Material.id_model = Model.id_model ";
                $jtab = $this->addJOIN($jtab, $j);
                $j = " JOIN `Type_material` ON Model.id_type = Type_material.id_type ";
                $jtab = $this->addJOIN($jtab, $j);
                $w = " Type_material.id_type = :id_type  ";
                $wtab = $this->addWHERE($wtab, ':id_type', $data['id_type'], $w);
            }

            // Select materials available between date X and date Y
            if(isset($data['date_begin']) && isset($data['date_end'])){
//                $args[':date_begin'] = $data['date_begin'];
//                $args[':date_end'] = $data['date_end'];
                $w = " id_material NOT IN (SELECT Material.id_material FROM Material 
                JOIN Model ON Material.id_model = Model.id_model
                JOIN Cart ON Material.id_material = Cart.id_material
                WHERE ( Cart.date_end <= :date_end AND Cart.date_begin >= :date_begin) AND Material.id_room IS NULL) ";
                $wtab = $this->addWHERE($wtab, ':date_end', $data['date_end'], $w);
                $date_begin = $data['date_begin'];
            }

            // Select all materials from a reservation
            if(isset($data['id_res'])){
                $j = " JOIN `Cart` ON Material.id_material = Cart.id_material ";
                $jtab = $this->addJOIN($jtab, $j);
                $j = " JOIN `Reservation` ON Cart.id_res = Reservation.id_res ";
                $jtab = $this->addJOIN($jtab, $j);
                $j = " JOIN `Model` ON Material.id_model = Model.id_model ";
                $jtab = $this->addJOIN($jtab, $j);
                $w = " Reservation.id_res = :id_res  ";
                $wtab = $this->addWHERE($wtab, ':id_res', $data['id_res'], $w);
            }

            // Select all materials from a reservation that is for a tp
            if(isset($data['id_res']) && isset($data['res_tp'])){
                $w = " Reservation.res_tp = :res_tp  ";
                $wtab = $this->addWHERE($wtab, ':res_tp', $data['res_tp'], $w);
            }

            // Select all materials from a reservation that is for a tp for a certain class
            if(isset($data['id_res']) && isset($data['tp']) && isset($data['id_class'])){
                $j = " JOIN `Reservation_tp` ON Reservation_tp.id_res = Reservation.id_res ";
                $jtab = $this->addJOIN($jtab, $j);
                $w = " Reservation_tp.id_class = :id_class  ";
                $wtab = $this->addWHERE($wtab, ':id_class', $data['id_class'], $w);
            }

            // Select all materials in a reservation that is late now
            if(isset($data['late_now'])){
                if($data['late_now'] == 1){
                    $date = date('Y-m-d h:i:s');
                    $j = " JOIN `Cart` ON Material.id_material = Cart.id_material ";
                    $jtab = $this->addJOIN($jtab, $j);
                    $j = " JOIN `Model` ON Material.id_model = Model.id_model ";
                    $jtab = $this->addJOIN($jtab, $j);
                    $w = " Cart.date_end < :now AND Cart.date_return IS NULL ";
                    $wtab = $this->addWHERE($wtab, ':now', $date, $w);
                }
            }

            // Select all materials that has been late
            if(isset($data['was_late'])){
                if($data['was_late'] == 1){
                    $j = " JOIN `Cart` ON Material.id_material = Cart.id_material ";
                    $jtab = $this->addJOIN($jtab, $j);
                    $j = " JOIN `Model` ON Material.id_model = Model.id_model ";
                    $jtab = $this->addJOIN($jtab, $j);
                    $w = " Cart.date_end < Cart.date_return ";
                    $wtab = $this->addWHERE($wtab, '', '', $w);
                }
            }

        }

        $where = $this->formatWHERE($wtab);
        $req .= $this->formatJOIN($jtab);
        $req .= $where["req"];
        $args = $where["args"];


        if($date_begin != NULL){
            $args[':date_begin'] = $date_begin;
        }

        // attention `lala` guillemets penchees pour les noms de table et col en SQL ("lala" guillemets double enSQLite)
        $this->res['data'] = $this->api->list($req, $args);
        $this->res['msg'] = "List the materials.";
        $this->stop(true);
    }

    public function add($data) {
        $this->isset($data, 'id_model', "Material model should be specified (add).");
        $this->isset($data, 'obsolete', "Material obsolete state should be specified (add).");
        $this->isset($data, 'in_repair', "Material in repair state should be specified (add).");
        $this->isset($data, 'date', "Material added date should be specified (add).");
        $this->isnum($data, 'id_model', "Material model should be numeric (add).");
        $this->isnum($data, 'obsolete', "Material obsolete should be numeric (add).");
        $this->isnum($data, 'in_repair', "Material in_repair should be numeric (add).");

        //To add a number automatically with the amount of material of the same model already present
        $model = [':id_model' => $data['id_model']];
        $number_search = " SELECT COUNT(*) FROM Material WHERE id_model = :id_model ";
        $number = $this->api->list($number_search, $model)[0]["COUNT(*)"]+1;
        //var_dump($number);


        //Insert
        $args = [':id_model' => $data['id_model'], ':number' => $number,':date' => $data['date'], ':obsolete'=> $data['obsolete'],
            ':in_repair' =>$data['in_repair']];
        $req = " INSERT INTO `Material` (`id_model`, `number`, `obsolete`, `in_repair`, `date_add`";

        //Conditions for the non-obligatory values
        if(isset($data['description']) && isset($data['id_room'])){
            $args[':description'] = $data['description'];
            $args[':id_room'] = $data['id_room'];
            $req .= ",`description_material`, `id_room`) VALUES (:id_model, :number, :obsolete, :in_repair, :date, :description, :id_room)";
        }
        elseif (isset($data['description'])){
            $args[':description'] = $data['description'];
            $req .= ",`description_material`) VALUES (:id_model, :number, :obsolete, :in_repair, :date, :description)";
        }
        elseif (isset($data['id_room'])){
            $args[':id_room'] = $data['id_room'];
            $req .= ",`id_room`) VALUES (:id_model, :number, :obsolete, :in_repair, :date, :id_room)";
        }
        else{
            $req .= ") VALUES (:id_model, :number, :obsolete, :in_repair, :date)";
        }

        $this->api->add($req, $args);
        //var_dump($req);
        $this->res['msg'] = "Material $number added.";
        $this->stop(true);
    }


    public function update($data) {
        $this->isset($data, 'id_material', "Material id should be specified (update).");
        $this->isnum($data, 'id_material', "Material id should be numeric (update).");

        $stab = [];
        $req = " UPDATE `Material` ";

        if(isset($data['obsolete'])){
            $s = " obsolete = :obsolete ";
            $stab = $this->addSET($stab, ':obsolete', $data['obsolete'], $s);
        }
        if(isset($data['number'])){
            $s = " number = :number ";
            $stab = $this->addSET($stab, ':number', $data['number'], $s);
        }
        if(isset($data['in_repair'])){
            $s = " in_repair = :in_repair ";
            $stab = $this->addSET($stab, ':in_repair', $data['in_repair'], $s);
        }
        if(isset($data['description'])){
            $s = " description_material = :description ";
            $stab = $this->addSET($stab, ':description', $data['description'], $s);
        }
        if(isset($data['id_room'])){
            if (!is_numeric($data['id_room'])) { $data['id_room'] = NULL; }
            $s = " id_room = :id_room ";
            $stab = $this->addSET($stab, ':id_room', $data['id_room'], $s);
        }
        if(isset($data['date_add'])){
            $s = " date_add = :date_add ";
            $stab = $this->addSET($stab, ':date_add', $data['date_add'], $s);
        }
        if(isset($data['id_model'])){
            $s = " id_model = :id_model ";
            $stab = $this->addSET($stab, ':id_model', $data['id_model'], $s);
        }

        $set = $this->formatSET($stab);
        $args = $set["args"];
        $args[':id_material'] = $data['id_material'];
        $req .= $set["req"];
        $req .= " WHERE id_material = :id_material ";


        $this->api->update($req, $args);
        $this->res['msg'] = "Material '{$data['id_material']}' updated.";
        $this->stop(true);
    }

    public function delete($data) {
        $this->isset($data, 'id_material', "id_material should be specified (delete).");
        $this->isnum($data, 'id_material', "id_material should be numeric (delete).");

        $args[':id_material'] = $data['id_material'];

        $this->api->delete(<<<EOL
                DELETE FROM `Material` WHERE `id_material` = :id_material
            EOL, $args);

        $this->res['msg'] = "Material '{$data['id_material']}' deleted.";
        $this->stop(false);
    }
}
?>
