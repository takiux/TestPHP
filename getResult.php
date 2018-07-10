<?php

require 'Manager.php';
use TestManager\Manager;

$manager = new manager;

try{
    $result = $manager->calculateInterest($_POST['country'], $_POST['amount'], $_POST['duration']);
    echo json_encode($result);
}
catch (Exception $e) 
{
    echo $manager->error(400, 'Error: ' .  $e->getMessage());
    exit();
}        


?>