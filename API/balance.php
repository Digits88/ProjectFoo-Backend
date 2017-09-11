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

//Warning: SQL-Injection
$result = $conn->query("SELECT * FROM users WHERE authcode='".$_POST['authcode']."'");
$matecoins = 0;

if($result == false){
    die("no such user");
}

$id = -1;
while($row = mysqli_fetch_object($result)){
    $id = $row->id;
    $matecoins = $row->matecoins;
}

$result = $conn->query("SELECT * FROM take_outs WHERE userid=".$id);

if($result == false){
    $array = [];
    die(json_encode(["items" => $array, "matecoins" => $matecoins, "summer" => 0]));
}

$summe = 0;
$items = [];
while($row = mysqli_fetch_object($result)){
    $repoid = $row->repositryid;
    $price = 0;
    $name = "";
    $reporesult = $conn->query("SELECT * FROM repositories WHERE id=".$repoid);
    while($reporow = mysqli_fetch_object($reporesult)){
        $drinkid = $reporow->drinkid;
        $drinkresult = $conn->query("SELECT * FROM drinks WHERE id=".$drinkid);
        while($drinkrow = mysqli_fetch_object($drinkresult)){
            $price = $drinkrow->price;
            $name = $drinkrow->name;
        }
    }
    $dataarray = [];
    if($row->free == 0){
        $summe = $summe+$price;
        $dataarray = ["name" => $name, "price" => $price];
    }else{
        $dataarray = ["name" => $name, "price" => 0];
    }
    array_push($items, $dataarray);
}

echo json_encode(["items" => $items, "matecoins" => $matecoins, "summe" => $summe]);
?>