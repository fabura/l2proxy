<?php
/** Created by bulat.fattahov 2013 */

$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

require "util/ConfigDAO.php";
require_once "util/ProxyUser.php";


switch ($method) {
    case 'POST':
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
    if (!isset($_GET['name'])) {
        echo json_encode(ConfigDAO::getUsersList());
        return;
    } else {
        $res = array_filter(ConfigDAO::getUsersList(), function ($user) {
            return $user->name == $_GET['name'];
        });
        if (sizeof($res) != 0) {
            echo json_encode($res[0]);
            return;
        }
    }

}

function rest_post($request)
{
    $name = $_POST["name"];
    $password = $_POST["password"];
    $expireDate = $_POST["expireDate"];
    $user = new ProxyUser($name, $password, $expireDate);
    if (isset($_POST["action"]) && $_POST["action"] == "new") {
        ConfigDAO::addUser($user);
    } else {
        ConfigDAO::editUser($user);
    }
}

function rest_delete($request)
{

}

function rest_error()
{

}




//if(isset())