<?php
/** Created by bulat.fattahov 2013 */

$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

require "util/ConfigDAO.php";
require_once "util/ProxyUser.php";


switch ($method) {
    case 'POST':
        $request_body = file_get_contents('php://input');
        $request = json_decode($request_body);
        rest_post($request);
        break;
    case 'GET':
        rest_get($request);
        break;
    case 'DELETE':
        rest_delete($request);
        break;
    default:
        rest_error($request);
        break;
}

function rest_get($request)
{
    if (!isset($_GET['id'])) {
        echo json_encode(ConfigDAO::getUsersList());
        return;
    } else {
        $user = ConfigDAO::getById($_GET['id']);
        echo json_encode($user);
    }

}

function rest_post($request)
{
    $id = $request->id;
    $name = $request->name;
    $password = $request->password;
    $expireDate = $request->expireDate;
    $disabled = $request->disabled;
    $user = new ProxyUser($id, $name, $password, $expireDate, $disabled);
    if ($request->id == null) {
        ConfigDAO::addUser($user);
    } else {
        ConfigDAO::editUser($user);
    }
}

function rest_delete($request)
{
    print("on deleting!");
    $id = $_GET["id"];
    ConfigDAO::removeUser($id);
}

function rest_error()
{

}




//if(isset())