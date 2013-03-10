<?php
/**
 * User: Bulat
 * Date: 10.03.13
 */

if (!isset($_GET["action"])) {
    return;
}
require "util/ConfigDAO.php";
$usersDAO = new ConfigDAO();
switch ($_GET["action"]) {
    case "list":
    {
        return json_encode($usersDAO->getUsersList());
    }
    case "create":
    {
        $fail = "{status: fail}";
        if (isset($_GET["name"])) {
            $userName = $_GET["name"];
        } else {
            return Status::fail("name is required!");
        }

        if (isset($_GET["password"])) {
            $userName = $_GET["password"];
        } else {
            return Status::fail("name is required!");
        }


    }
    case "edit":
    {
    }
    case "delete":
    {
    }
    case "backup":
    {
    }
    default:
        {
        return;
        }
        ;

}
;

function getField($fieldName, $default = null)
{
    if (isset ($_GET[$fieldName])) {
        return $_GET[$fieldName];
    } elseif (isset($default)) {
        return $default;
    } else {
        return Status::fail("$fieldName is required!");
    }
}

class Status
{
    public static function success($val)
    {
        return "{status:success, result:$val}";
    }

    public static function fail($message)
    {
        return "{status:fail, result:$message}";
    }
}