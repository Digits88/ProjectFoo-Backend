<?php
header("Access-Control-Allow-Origin: *");
if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
    $headers =getallheaders();
    @$ACRH=$headers['Access-control-Reque: $ACRH'];
}
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, UPDATE");

if(!$_POST['fridgeidentifier']){
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

//Warning: SQL-Injection
$result = $conn->query("SELECT * FROM fridges WHERE identifier='".$_POST['fridgeidentifier']."'");

if($result == false){
    die(null);
}
if($result->num_rows != 1){
    die(null);
}else{
    while($row = mysqli_fetch_object($result))
    {
        $resultrepo = $conn->query("SELECT * FROM repositories WHERE fridgeid=".$row->id);
        $repoarray = [];
        if($resultrepo != false){
            while($reporow = mysqli_fetch_object($resultrepo)){
                $drinknamequery = $conn->query("SELECT * FROM drinks WHERE id=".$reporow->drinkid);
                if($drinknamequery != false){
                    while($dringkname = mysqli_fetch_object($drinknamequery)){
                        $dataarray = [$reporow->id, $dringkname->name, $dringkname->price, $reporow->amount];
                        array_push($repoarray, $dataarray);
                    }
                }
            }
        }
        die(json_encode(["name" => $row->name, "location" => $row->location, "repositories" => $repoarray]));
    }
}
?>