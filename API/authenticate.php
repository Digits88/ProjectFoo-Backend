<?php
header("Access-Control-Allow-Origin: *");
    if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
        $headers =getallheaders();
        @$ACRH=$headers['Access-control-Reque: $ACRH'];
    }
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, UPDATE");
if(!$_POST['authcode']){
    die("missing parameter");
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "foo";
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if(!is_numeric($_POST['authcode'])){
    die("invalid parameter");
}
$result = $conn->query("SELECT * FROM USERS WHERE auth=".$_POST['authcode']);
if($result->num_rows != 1){
    die(null);
}else{
    while($row = mysqli_fetch_object($result))
    {
        die(json_encode(["name" => $row->name, "matemarken" => $row->matemarken, "matecounter" => $row->matecounter]));
    }
}
?>
