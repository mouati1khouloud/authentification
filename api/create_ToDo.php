<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// database connection will be here
// files needed to connect to database
include_once 'config/database.php';
include_once 'objects/user.php';
include_once 'objects/ToDo.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// instantiate product object
$user = new User($db);
$ToDo = new ToDo($db);

// submitted data will be here

// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set product property values
$ToDo->task = $data->task;
$ToDo->dateTask = $data->dateTask;
$ToDo->idUser= $data->idUser;

 
// use the create() method here
// create the user
if($ToDo->create()){
 
    // set response code
    http_response_code(200);
 
    // display message: user was created
    echo json_encode(array("message" => "ToDo was created."));
}
 
// message if unable to create user
else{
 
    // set response code
    http_response_code(400);
 
    // display message: unable to create user
    echo json_encode(array("message" => "Unable to create ToDo."));
}
?>