<?php
/** Created by bulat.fattahov 2013 */
class ProxyUser
{
    var $name;
    var $password;
    var $expireDate;
    var $disabled;

    static function  createFromLine($line){
        if(preg_match('/^\s*(\#?)\s*(\w[^:]*):CL:(\S+)\s+#(\d{1,2}\.\d{1,2}.\d{4})/m', $line, $matches)){
            $disabled = strlen($matches[1]) == 1;
            $name = $matches[2];
            $password = $matches[3];
            $expireDate = $matches[4];
            return new ProxyUser($name, $password, $expireDate, $disabled);
        }
    }

    function __construct($name, $password, $expireDate, $disabled = false)
    {
        $this->expireDate = $expireDate;
        $this->name = $name;
        $this->password = $password;
        $this->disabled = $disabled;
    }

    public function isExpired()
    {
        return DateTime::createFromFormat("d.m.Y", $this->expireDate) < new DateTime("now");
    }

    public function toString() {
        $str = "";
        if($this->disabled){$str .= "#";}
        $str .=$this->name.":CL:".$this->password."\t\t#".$this->expireDate;
        return $str;
    }
}
