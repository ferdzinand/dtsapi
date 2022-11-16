<?php
header("Access-Control-Allow-Origin: *");
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require '../src/vendor/autoload.php';
$app = new \Slim\App;

//endpoint get greeting
$app->get('/getName/{fname}/{lname}', function (Request $request, Response

$response, array $args) {
$name = $args['fname']." ".$args['lname'];
$response->getBody()->write("Hello, $name");
return $response;

});






//localhost/DTS/api/public/postName
//endpoint post greeting
$app->post('/postName', function (Request $request, Response $response, array $args)
{
return $response;
});



//testing by ferdz
//localhost/DTS/api/public/postPrint
//endpoint post print
$app->post('/postPrint', function (Request $request, Response $response, array $args) {//Database

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dtsystem";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM document_fields";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    $data=array();
    while($row = $result->fetch_assoc()) {


    array_push($data,array(
    "dtnumber"=>$row["dtnumber"]
    ,"document_title"=>$row["document_title"]
    ,"doc_type"=>$row["doc_type"]
    ,"document_origin"=>$row["document_origin"]
    ,"date_recieved"=>$row["date_recieved"]
    ,"document_destination"=>$row["document_destination"]
    ,"tag"=>$row["tag"]));
    }
    $data_body=array("status"=>"success","data"=>$data);
    $response->getBody()->write(json_encode($data_body));
    } else {
    $response->getBody()->write(array("status"=>"success","data"=>null));
    }
    $conn->close();





return $response;
});

$app->run();
?>