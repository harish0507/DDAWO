<?php

/*
 *District Differently Ablef Welfare Office
 *
 *returns selected user info as json
 *
 *@author Harish Mohan <harish@brandidea.com>
 *@version 1.0
 *
*/

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: POST');

if($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)) {
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $id = $request->id;
    
    $con = new mysqli("127.0.0.1", "root", "", "ddawo");
    if($con->connect_errno) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        die(json_encode(array()));
    }
    
    $sql = "select * from ddawo.users where national_id = {$id}";
    $result = $con->query($sql);
    $data = array();
    while($value = mysqli_fetch_assoc($result)) {
        $data[] = $value;
    }
    
    header("Content-Type: application/json");
    echo json_encode($data);
}