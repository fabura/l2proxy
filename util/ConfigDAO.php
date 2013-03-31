<?php
/** Created by bulat.fattahov 2013 */
require "ProxyUser.php";
class ConfigDAO
{
    static private $configPath = "./test/user.cfg";

    public static function getUsersList()
    {
        $lines = file(self::$configPath, FILE_SKIP_EMPTY_LINES);
        $users = array();
        foreach ($lines as $line) {
            $proxyUser = ProxyUser::createFromLine($line);
            if ($proxyUser != null) {
                $users[] = $proxyUser;
            }
        }
        return $users;
    }

    public static function getUsersAsArrays()
    {
        $result = array();
        foreach (self::getUsersList() as $user) {
            $result[] = $user->toArray();
        }
        return $result;
    }

    private static function saveUsersList($users)
    {
        $str = "######### USERS #########\n";
        foreach ($users as $user) {
            $str .= $user->toString() . "\n";
        }

        $file = fopen(self::$configPath, "w");
        fwrite($file, $str);
        fclose($file);
    }

    public static function removeUser($id)
    {
        $users = self::getUsersList();
        $result = array();
        foreach ($users as $user) {
            if ($user->id != $id) {
                $result[] = $user;
            }
        }
        self::saveUsersList($result);
    }

    public static function addUser($user)
    {
        print("adding new user;");
        $users = self::getUsersList();
        $maxId= 0;
        foreach ($users as /* @ProxyUser*/ $oldUser) {
            if($oldUser->id > $maxId){$maxId = $oldUser->id;}
        }
        print($maxId+1);
        $user->id = $maxId +1;
        print($user->toString());
        $users[] = $user;
        self::saveUsersList($users);
    }

    public static function editUser($newUser)
    {
        $users = self::getUsersList();
        $result = array();
        foreach ($users as $oldUser) {
            if ($oldUser->id == $newUser->id) {
                $result[] = $newUser;
            } else {
                $result[] = $oldUser;
            }
        }
        self::saveUsersList($result);
    }

    public static function getById($id)
    {
        $res = array();
        foreach (self::getUsersList() as $user) {
            if ($user->id == $id) {
                $res[] = $user;
            }
        }
        if (count($res) > 1) {
            throw Exception("There is duplicated id");
        } elseif (count($res) == 0) {
            return null;
        } else {
            return $res[0];
        }
    }
}


