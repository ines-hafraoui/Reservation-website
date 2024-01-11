<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Reservation {
    use Controller;

    public function list($data)
    {
        $wtab = [];
        $jtab = [];
        $req = "SELECT * FROM `Reservation` 
                JOIN `Cart` ON Cart.id_res = Reservation.id_res
                LEFT JOIN `Material`ON Material.id_material = Cart.id_material
                ";
        $date_end = NULL;


        if(sizeof($data) > 0){
            if (isset($data['id_res'])){
                $w = " Reservation.id_res = :id_res ";
                $wtab = $this->addWHERE($wtab, ':id_res', $data['id_res'], $w);
            }
            if (isset($data['login'])) {
                $req = "SELECT * FROM `Reservation`";
                $w = " `login` = :login ";
                $wtab = $this->addWHERE($wtab, ':login', $data['login'], $w);
            }
            if (isset($data['id_status'])) {
                $w = " `id_status` = :id_status ";
                $wtab = $this->addWHERE($wtab, ':id_status', $data['id_status'], $w);
            }
            if (isset($data['id_room'])) {
                $w = " Cart.id_room = :id_room ";
                $wtab = $this->addWHERE($wtab, ':id_room', $data['id_room'], $w);
            }
            if (isset($data['res_tp'])) {
                $w = " `res_tp` = :res_tp ";
                $wtab = $this->addWHERE($wtab, ':res_tp', $data['res_tp'], $w);
            }
            if (isset($data['id_class'])) {
                $j = "JOIN Reservation_tp.id_class = Reservation.id_class";
                $jtab = $this->addJOIN($jtab, $j);
                $w = " Reservation_tp.id_class = :id_class ";
                $wtab = $this->addWHERE($wtab, ':id_class', $data['id_class'], $w);
            }
            if (isset($data['member'])) {
                $j = " JOIN Member ON Member.id_res = Reservation.id_res ";
                $w = " Member.login = :member OR Reservation.login = :member";
                $jtab = $this->addJOIN($jtab, $j);
                $wtab = $this->addWHERE($wtab, ':member', $data['member'], $w);
            }
            if (isset($data['id_material'])) {
                $w = " Material.id_material = :id_material";
                $wtab = $this->addWHERE($wtab, ':id_material', $data['id_material'], $w);
            }
            if (isset($data['today']) && $data['today'] == true) {
                $currentDate = date('Y-m-d');
                $w = " Cart.date_begin LIKE CONCAT(:today, '%')";
                $wtab = $this->addWHERE($wtab, ':today', $currentDate, $w);
            }
            if (isset($data['back']) && $data['back'] == true) {
                $currentDate = date('Y-m-d');
                $w = " Cart.date_end LIKE CONCAT(:currentDate, '%')";
                $wtab = $this->addWHERE($wtab, ':currentDate', $currentDate, $w);
            }
            if (isset($data['date_return'])) {
                $w = " Cart.date_end LIKE CONCAT(:date_return, '%')";
                $wtab = $this->addWHERE($wtab, ':date_return', $data['date_return'], $w);
            }
            if (isset($data['date_begin']) && !isset($data['date_end'])) {
                $w = " Cart.date_begin LIKE CONCAT(:date_begin, '%')";
                $wtab = $this->addWHERE($wtab, ':date_begin', $data['date_begin'], $w);
            }
            if (isset($data['date_end']) && !isset($data['date_begin'])) {
                $w = " Cart.date_end LIKE CONCAT(:date_end, '%')";
                $wtab = $this->addWHERE($wtab, ':date_end', $data['date_end'], $w);
            }
            if (isset($data['date_begin']) && isset($data['date_end'])) {
                $w = "Cart.date_begin >= :date_begin AND Cart.date_end <= :date_end";
                $wtab = $this->addWHERE($wtab, ':date_begin', $data['date_begin'], $w);
                $date_end = $data['date_end'];
            }
            if (isset($data['late']) && $data['late'] == true) {
                $currentDate = date('Y-m-d h:i:s');
                $w = " :currentDate > Cart.date_end AND Cart.date_return IS NULL";
                $wtab = $this->addWHERE($wtab, ':currentDate', $currentDate, $w);
            }
            if (isset($data['now']) && $data['now'] == true) {
                $currentDate = date('Y-m-d h:i:s');
                $w = " :currentDate > Cart.date_begin AND Cart.date_return IS NULL";
                $wtab = $this->addWHERE($wtab, ':currentDate', $currentDate, $w);
            }
        }

        $where = $this->formatWHERE($wtab);
        $req.= $this->formatJOIN($jtab);
        $req .= $where["req"];
        $args = $where["args"];
        if ($date_end != NULL) { $args['date_end'] = $date_end; }
        $this->res['data'] = $this->api->list($req, $args);
        $this->res['msg'] = "List the reservations.";
        $this->stop(true);
    }
    public function add($data) {
        $this->isset($data, 'login', "login should be specified (add).");

        $args[':login'] = $data['login'];

        if (!isset($data['id_class'])){
            $this->api->add(<<<EOL
                INSERT INTO `Reservation` (`login`, `id_status`,`res_tp` ) VALUES (:login, 1, 0);
            EOL, $args);
        } else {
            $args[':id_class'] = $data['id_class'];
            $this->api->add(<<<EOL
                INSERT INTO `Reservation` (`login`, `id_status`,`res_tp` ) VALUES (:login, 1, 1);
                INSERT INTO `Reservation_tp` (`id_res`, `id_class`)
                SELECT `id_res`, :id_class FROM `Reservation`
                WHERE `login` = :login AND `id_status` = 1 AND `res_tp` = 1
                ORDER BY `id_res` DESC
                LIMIT 1;
            EOL, $args);
        }

        $this->res['msg'] = "Reservation added.";
        $this->stop(true);
    }
    public function update($data) {
        $this->isset($data, 'id_res', "id_res should be specified (update).");

        $args[':id_res'] = $data['id_res'];

        if (isset($data['id_status'])){
            $args[':id_status'] = $data['id_status'];
            $this->api->update(<<<EOL
                UPDATE `Reservation`
                SET `id_status` = :id_status
                WHERE `id_res` = :id_res;
            EOL, $args);
        }
        if (isset($data['id_class'])){
            $args[':id_class'] = $data['id_class'];
            $this->api->update(<<<EOL
                UPDATE `Reservation_tp`
                SET `id_class` = :id_class
                WHERE `id_res` = :id_res;
            EOL, $args);
        }
        $this->res['msg'] = "Reservation '{$data['id_res']}' updated.";
        $this->stop(true);
    }
    public function delete($data) {
        $this->isset($data, 'id_res', "id_res should be specified (delete).");

        $args[':id_res'] = $data['id_res'];

        $req = "DELETE FROM `Cart`
                       WHERE `id_res` = :id_res;
                DELETE FROM `Reservation_tp`
                     WHERE `id_res` = :id_res;
                DELETE FROM `Member`
                     WHERE `id_res` = :id_res;
                DELETE FROM `Problem`
                       WHERE `id_res` = :id_res;
                DELETE FROM `Reservation`
                       WHERE `id_res` = :id_res;";

            $this->api->delete($req,$args);


        $this->res['msg'] = "reservation deleted.";
        $this->stop(false);
    }
}
