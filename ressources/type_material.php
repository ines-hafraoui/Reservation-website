<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Type
{
    use Controller;

    public function list($data)
    {
        $args = [];

        $req = "SELECT * FROM `Type_material`";

        $this->res['data'] = $this->api->list($req, $args);
        $this->res['msg'] = "List all member from the types of material.";
        $this->stop(true);

    }

    public function add($data){}
    public function update($data){}
    public function delete($data){}
}

?>