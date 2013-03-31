<?php
/** Created by bulat.fattahov 2013 */
class ProxyUser
{
    var $id;
    var $name;
    var $password;
    var $expireDate;
    var $disabled;

    /**
     * @param $line
     * @return null|ProxyUser
     */
    static function  createFromLine($line)
    {
        if (preg_match('/^\s*(\#?)\s*(\w[^:]*):CL:(\S+)\s+#(\d{1,2}\.\d{1,2}.\d{4})\s+#(\d+)/m', $line, $matches)) {
            $disabled = strlen($matches[1]) == 1;
            $name = $matches[2];
            $password = $matches[3];
            $expireDateRaw = $matches[4];
            $expireDate = preg_replace('/(\d{1,2})\.(\d{1,2}).(\d{4})/','$3-$2-$1' ,$expireDateRaw);
            $id = $matches[5];
            return new ProxyUser($id, $name, $password, $expireDate, $disabled);
        }
        return null;
    }

    function __construct($id, $name, $password, $expireDate, $disabled = false)
    {
        $this->id = $id;
        $this->expireDate = $expireDate;
        $this->name = $name;
        $this->password = $password;
        $this->disabled = $disabled;
    }

    public function isExpired()
    {
        return DateTime::createFromFormat("d.m.Y", $this->expireDate) < new DateTime("now");
    }

    public function toString()
    {
        $str = "";
        if ($this->disabled) {
            $str .= "#";
        }
        $str .= $this->name . ":CL:" . $this->password . "\t\t#" . preg_replace('/(\d{4})-(\d{1,2})-(\d{1,2})/','$3.$2.$1',$this->expireDate) . "\t#" . $this->id;
        return $str;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'password' => $this->password,
            'expireDate' => $this->expireDate,
            'disabled' => $this->disabled
        );
    }
}