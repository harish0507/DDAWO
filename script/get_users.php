<?php

/*
 *District Differently Ablef Welfare Office
 *
 *returns all user info as json
 *
 *@author Harish Mohan <harish@brandidea.com>
 *@version 1.0
 *
*/

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET');

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $con = new mysqli("127.0.0.1", "root", "", "ddawo");
    if($con->connect_errno) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        die(json_encode(array()));
    }
    
    $sql = "select * from ddawo.users";
    $result = $con->query($sql);
    $data = array();
    while($value = mysqli_fetch_assoc($result)) {
        $data[] = $value;
    }
    
    header("Content-Type: application/json");
    echo json_encode($data);
}