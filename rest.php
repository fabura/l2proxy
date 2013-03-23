<?php
/** Created by bulat.fattahov 2013 */

$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

require "util/ConfigDAO.php";


switch ($method) {
    case 'PUT':
        rest_put($request);
        break;
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

function rest_put($request)
{

}

function rest_get($request)
{
    if (!isset($_GET['id'])) {
        echo json_encode(ConfigDAO::getUsersList());
        return;
    }
}

function rest_post($request)
{

}

function rest_delete($request)
{

}

function rest_error($request)
{

}




//if(isset())