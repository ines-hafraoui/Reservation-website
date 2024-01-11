<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'] . '/api/bd.php';

class API extends BDHandler {
    public function add($req, $args) { $this->instruct($req,$args); }
    public function list($req, $args) { return $this->select($req, $args); }
    public function update($req, $args) { $this->instruct($req, $args); }
    public function delete($req, $args) { $this->instruct($req, $args); }
}

function stop($status, $res) {
    $res['status'] = $status;
    echo json_encode($res);
    exit();
}

trait Controller {
    private $res;
    private $api;

    public function __construct($res) {
        $this->res = $res;
        $this->api = new API();
    }

    public function stop($status) {
        stop($status, $this->res);
    }

    public function isset($data, $key, $msg) {
        if (!isset($data[$key]) or $data[$key] == '') {
            $this->res['msg'] = $msg;
            $this->stop(false);
        }
    }

    public function isnum($data, $key, $msg) {
        if (!is_numeric($data[$key])) {
            $this->res['msg'] = $msg;
            $this->stop(false);
        }
    }

    //methods to make multiple joins in one req
    public function addJOIN($jtab, $j) {
        foreach ($jtab as $v){
            if($v['req'] == $j){
                return $jtab;
            }
        }
        $jtab[] = [ 'req' => $j ];
        return $jtab;
    }
    public function formatJOIN($jtab) {
        $req = " ";
        foreach ($jtab as $v){
            $req .= $v['req'];
        }
        return $req;
    }

    //methods to add multiple conditions for a where in one req
    public function addWHERE($wtab, $var, $val, $w) {
        foreach ($wtab as $v){
            if($v['req'] == $w){
                return $wtab;
            }
        }
        if($var == '' AND $val == ''){
            $wtab[] = [
                'req' => $w
            ];
            return $wtab;
        }
        else{
            $wtab[] = [
                'var' => $var,
                'val' => $val,
                'req' => $w
            ];
            return $wtab;
        }

    }
    public function formatWHERE($wtab) {
        $args = [];
        $req = "";
        for ($id = 0; $id < sizeof($wtab); $id++){
            if( isset($wtab[$id]['var']) && isset($wtab[$id]['val']) ){
                $args[$wtab[$id]['var']] = $wtab[$id]['val'];
            }
            if ($id == 0) {
                $req = " WHERE ";
                $req .= $wtab[$id]['req'];
            }
            else {
                $req .= " AND ";
                $req .= $wtab[$id]['req'];
            }
        }
        return ["req" => $req, "args" => $args];
    }

    //two methods to set multiple values in one req
    public function addSET($stab, $var, $val, $s) {
        foreach ($stab as $v){
            if($v['req'] == $s){
                return $stab;
            }
        }
        $stab[] = [
            'var' => $var,
            'val' => $val,
            'req' => $s
        ];
        return $stab;

    }
    public function formatSET($stab) {
        $args = [];
        $req = "";
        for ($id = 0; $id < sizeof($stab); $id++){
            $args[$stab[$id]['var']] = $stab[$id]['val'];
            if ($id == 0) {
                $req = " SET ";
                $req .= $stab[$id]['req'];
            }
            else {
                $req .= " , ";
                $req .= $stab[$id]['req'];
            }
        }
        return ["req" => $req, "args" => $args];
    }

    public abstract function list($data);
    public abstract function add($data);
    public abstract function update($data);
    public abstract function delete($data);
}



if (!isset($_SERVER['REQUEST_URI'])) { $_SERVER['REQUEST_URI'] = '/api/'; }
$rest = explode('/', explode('?',$_SERVER['REQUEST_URI'])[0]);
array_shift($rest);
array_shift($rest);
//$args = $_GET;
try {
    $args = json_decode(file_get_contents('php://input'), true);
}
catch (Exception $e) {
    echo "noob";
};

header('Content-type: application/json; charset=utf-8');
$res = array(
    'status' => false,
    'rest' => $rest,
    'args' => $args,
    'msg' => 'Nothing happened.',
    'data' => 'nothing'
);

if (sizeof($rest) < 2) {
    $res['msg'] = 'No enough arguments.';
    stop(false, $res);
}

$resource = $rest[0];
$method = $rest[1];

//This verifies the resources and methods that can be used in the url (more can/will be added to the arrays)
if (!in_array($resource, array('material', 'user', 'reservation', 'problem', 'class',
    'room','cart','model','member','reservation_tp','user_class', 'role', 'status_res', 'type'))) {
    $res['msg'] = "Resource '${resource}' is unknown.";
    stop(false, $res);
}

if (!in_array($method, array('list', 'add', 'update', 'delete'))) {
    $res['msg'] = "Method '${$method}' is unknown.";
    stop(false, $res);
}

switch ($resource) {
    case 'material':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/ressources/material.php';
        $o = new Material($res);
        $o->{$method}($args);
        break;
    case 'user':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/ressources/user.php';
        $o = new User($res);
        $o->{$method}($args);
        break;
    case 'class':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/ressources/class.php';
        $o = new Group($res);
        $o->{$method}($args);
        break;
    case 'problem':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/ressources/problem.php';
        $o = new Problem($res);
        $o->{$method}($args);
        break;
    case 'member':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/ressources/member.php';
        $o = new Member($res);
        $o->{$method}($args);
        break;
    case 'room':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/ressources/room.php';
        $o = new Room($res);
        $o->{$method}($args);
        break;
    case 'reservation':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/ressources/reservation.php';
        $o = new Reservation($res);
        $o->{$method}($args);
        break;
    case 'model':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/ressources/model.php';
        $o = new Model($res);
        $o->{$method}($args);
        break;
    case 'cart':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/ressources/cart.php';
        $o = new Cart($res);
        $o->{$method}($args);
        break;
    case 'user_class':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/ressources/userClass.php';
        $o = new User_Class($res);
        $o->{$method}($args);
        break;
    case 'role':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/ressources/role.php';
        $o = new Role($res);
        $o->{$method}($args);
        break;
    case 'type':
        require_once $_SERVER['DOCUMENT_ROOT'] . '/ressources/type_material.php';
        $o = new Type($res);
        $o->{$method}($args);
        break;
    default:
        $res['msg'] = "Resource '${resource}' is not yet implemented.";
        stop(false, $res);
}
?>
