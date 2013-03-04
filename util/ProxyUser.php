<?php
/** Created by bulat.fattahov 2013 */
class ProxyUser
{
    var $name;
    var $password;
    var $expireDate;

    function __construct($name, $password, $expireDate)
    {
        $this->expireDate = $expireDate;
        $this->name = $name;
        $this->password = $password;
    }

    public function isExpired()
    {
        return DateTime::createFromFormat("m,d,Y", $this->expireDate) < new DateTime("now");
    }
}
