<?php

class BDHandler {
    public $DB = 'mysql:host=localhost;dbname=asaed4';
    public $USER = 'asaed4';
    public $PWD = 'PhooJ4ze';
    public $conn;

    public function __construct() {
        $this->conn = NULL;
    }

    public function connect() {
        $this->disconnect();
        try{
            $this->conn = new PDO($this->DB, $this->USER, $this->PWD);
        } catch (PDOException $e){
            die ("Failed: ".$e);
        }
    }

    public function disconnect() {
        if ($this->isConnected()) {
           // $this->conn->query('KILL CONNECTION_ID()');
            $this->conn = NULL;
        }
    }

    private function isConnected() {
        return $this->conn != NULL;
    }

    public function query($req) {
        if (!$this->isConnected()) { return false; }
        return $this->conn->query($req);
    }

    // appel de la methode prepare de PDO
    public function prepare($req) {
        if (!$this->isConnected()) { return false; }
        return $this->conn->prepare($req);
    }

    public function beginTransaction() {
        return $this->conn->beginTransaction();
    }

    public function rollBack() {
        return $this->conn->rollBack();
    }

    public function commit() {
        return $this->conn->commit();
    }

    function cleanup($tab){
        $cleantab = [];
        foreach($tab as $intab){
            $cur = array();
            foreach ($intab as  $key => $value){
                if(!is_numeric($key)){
                    $cur[$key]=$value;
                }
            }
            $cleantab[]=$cur;
        }
        return $cleantab;
    }

    public function select($req,$args) {
        $this->connect();
//        var_dump($req);
//        var_dump($args);
//        $res = $this->query($req);
        // prepare est une methode de PDO, on a donc cree une methode prepare dans la classe API
        $res = $this->prepare($req);
        $res->execute($args);
        $rows = $res->fetchAll();
        $this->disconnect();
        return $this->cleanup($rows);
    }

    public function instruct($req,$args) {
//        $this->connect();
//        $res = $this->prepare($req);
//        $res->closeCursor();
//        $this->connect();
//        var_dump($req);
//
//        $res = $this->prepare($req);
//        try {
//
//            $this->beginTransaction();
//
//            $res->execute($args);
//
//            $this->commit();
//
//        } catch (PDOException $e) {
//            echo 'coucou roll back';
//            $this->rollBack();
//        }
////        $res = $this->query($req);
//        $this->disconnect();
//        return $res;



        $this->connect();
//        var_dump($req);

        $reqs = explode(';', $req);
//        var_dump($reqs);

        $ps =[];
        $as =[];
        foreach ($reqs as $r) {
            if ($r == '') { continue; }
            $ps[] = $this->prepare($r);
            $a = [];
            foreach ($args as $key => $val) {
                if (strpos($r, $key)) {
                    $a[$key] = $val;
                }
            }
            $as[] = $a;
        }
        var_dump($ps);
        var_dump($as);

//        var_dump($args);

        try {

            $this->beginTransaction();


            for ($k = 0; $k < sizeof($ps); $k++) {
                $ps[$k]->execute($as[$k]);
            }

            $this->commit();

        } catch (PDOException $e) {
            echo 'coucou roll back';
            var_dump($e);
            $this->rollBack();
        }
//        $res = $this->query($req);
        $this->disconnect();
//        return $res;

    }
}

?>
