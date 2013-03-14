<?php
/** Created by bulat.fattahov 2013 */

require "util/ConfigDAO.php";

if(!isset($_GET['id'])){
    echo json_encode(ConfigDAO::getUsersList());
    return;
}

//if(isset())