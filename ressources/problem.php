<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Problem {
    use Controller;

    public function list($data)
    {
        $wtab = [];
        $req = "SELECT * FROM `Problem`";


        if(sizeof($data) > 0){
            if (isset($data['id_problem'])){
                $w = " `id_problem` = :id_problem ";
                $wtab = $this->addWHERE($wtab, ':id_problem', $data['id_problem'], $w);
            }
            if (isset($data['id_material'])) {
                $w = " `id_material` = :id_material ";
                $wtab = $this->addWHERE($wtab, ':id_material', $data['id_material'], $w);
            }
            if (isset($data['id_res'])) {
                $w = " `id_res` = :id_res ";
                $wtab = $this->addWHERE($wtab, ':id_res', $data['id_res'], $w);
            }
            if (isset($data['login'])) {
                $w = " `login` = :login ";
                $wtab = $this->addWHERE($wtab, ':login', $data['login'], $w);
            }
        }

        $where = $this->formatWHERE($wtab);
        $req .= $where["req"];

        $this->res['data'] = $this->api->list($req, $where["args"]);
        $this->res['msg'] = "List the problems.";
        $this->stop(true);
    }

    public function add($data)
    {
        $this->isset($data, 'problem_desc', "Problem description should be specified (add).");
        if (!isset($data['id_material']) && !isset($data['id_res']) && !isset($data['login'])) {
            $this->res['msg'] = 'At least one target must be specified.';
            $this->stop(false);
        }

        if (!isset($data['id_material'])) { $data['id_material'] = null; }
        if (!isset($data['id_res'])) { $data['id_res'] = null; }
        if (!isset($data['login'])) { $data['login'] = null; }

        $req = "
                INSERT INTO `Problem` (`id_material`, `id_res`, `login`, `problem_desc`)
                VALUES (:id_material, :id_res, :login, :problem_desc)
                ";

        $args = [
            ':id_material' => $data['id_material'],
            ':id_res' => $data['id_res'],
            ':login' => $data['login'],
            ':problem_desc' => $data['problem_desc'],
        ];

        $this->api->add($req, $args);
        $this->res['msg'] = "Problem added.";
        $this->stop(true);
    }

    public function update($data)
    {
        $this->isset($data, 'id_problem', "Problem Id should be specified (update).");
        $this->isnum($data, 'id_problem', "Problem Id should be numeric (update).");

        $stab = [];
        $wtab = [];

        $req = "UPDATE `Problem`";

        if (isset($data['id_material'])) {
            if (!is_numeric($data['id_material'])) { $data['id_material'] = NULL; }
            $s = " `id_material` = :id_material ";
            $stab = $this->addSET($stab, ':id_material', $data['id_material'], $s);
        }
        if (isset($data['id_res'])) {
            if (!is_numeric($data['id_res'])) { $data['id_res'] = NULL; }
            $s = " `id_res` = :id_res ";
            $stab = $this->addSET($stab, ':id_res', $data['id_res'], $s);
        }
        if (isset($data['login'])) {
            $s = " `login` = :login ";
            $stab = $this->addSET($stab, ':login', $data['login'], $s);
        }
        if (isset($data['problem_desc'])) {
            $s = " `problem_desc` = :problem_desc ";
            $stab = $this->addSET($stab, ':problem_desc', $data['problem_desc'], $s);
        }

        $set = $this->formatSET($stab);
        $req .= $set["req"];

        $w = " `id_problem` = :id_problem ";
        $wtab = $this->addWHERE($wtab, ':id_problem', $data['id_problem'], $w);
        $where = $this->formatWHERE($wtab);
        $req .= $where["req"];

        $args = $set["args"] + $where["args"];

        $this->api->update($req, $args);
        $this->res['msg'] = "Problem '{$data['id_problem']}' updated.";
        $this->stop(true);
    }

    public function delete($data)
    {
         $this->isset($data, 'id_problem', "Problem id should be specified (delete).");
        $this->isnum($data, 'id_problem', "Problem id should be numeric (delete).");

        $req = <<<EOL
                DELETE FROM `Problem` WHERE `id_problem` = :id_problem;
EOL;

        $args = [':id_problem' => $data['id_problem']];

        $this->api->delete($req, $args);
        $this->res['msg'] = "Problem '{$data['id_problem']}' deleted.";
        $this->stop(true);
    }
}
?>
