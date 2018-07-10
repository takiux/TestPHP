<?php

// this is put in a seperate file for the lack of a router.

require 'Manager.php';
use TestManager\Manager;

$manager = new manager;

try{

    $countryId = $_POST['country'];
    $amount = $_POST['amount'];
    $duration = $_POST['duration'];


    $result = $manager->calculateInterest($countryId, $amount, $duration);

    echo json_encode($result);
}
catch (Exception $e) 
{
    echo $manager->error(400, 'Error: ' .  $e->getMessage());
    exit();
}        


?>