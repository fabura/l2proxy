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

    public static function getUsersAsArrays(){
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

    public static function removeUser($userName)
    {
        $users = self::getUsersList();
        $result = array();
        foreach ($users as $user) {
            if ($user->name != $userName) {
                $result[] = $user;
            }
        }
        self::saveUsersList($result);
    }

    public static function addUser($user)
    {
        $users = self::getUsersList();
        $users[] = $user;
        self::saveUsersList($users);
    }

    //name could not change
    public static function editUser($newUser)
    {
        $users = self::getUsersList();
        $result = array();
        foreach ($users as $oldUser) {
            if ($oldUser->name == $newUser->name) {
                $result[] = $newUser;
            } else {
                $result[] = $oldUser;
            }
        }
        self::saveUsersList($result);
    }
}


