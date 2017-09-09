<?php
header("Access-Control-Allow-Origin: *");
if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
    $headers =getallheaders();
    @$ACRH=$headers['Access-control-Reque: $ACRH'];
}
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, UPDATE");

if(!$_POST['authcode'] || !$_POST['repositoryid']){
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
$result = $conn->query("SELECT * FROM users WHERE authcode=".$_POST['authcode']);

if($result == false){
    die("no such user");
}

$matemarken = -1;
$userid = -1;
while($row = mysqli_fetch_object($result)){
    $matemarken = $row->matecoins;
    $userid = $row->id;
}

$result = $conn->query("SELECT * FROM repositories WHERE id='".$_POST['repositoryid']."'");

if($result == false){
    die("missing repository");
}

$drinkid = -1;
$amount = -1;
while($row = mysqli_fetch_object($result)){
    $drinkid = $row->drinkid;
    $amount = $row->amount;
}

if($amount == 0){
    die("keine Getränk mehr verfügbar");
}

$result = $conn->query("SELECT * FROM drinks WHERE id=".$drinkid);

if($result == false){
    die("missing drink");
}

$drinname = "";
$price = -1;
$isCoinable = false;
while($row = mysqli_fetch_object($result)){
    $drinknmae = $row->name;
    $price = $row->price;
    if($row->isCoinable == 0){
        $isCoinable = false;
    }else{
        $isCoinable = true;
    }
}

if($isCoinable == 1 && $matemarken > 0){
    $conn->query("UPDATE users SET matecoins=".($matemarken-1)." WHERE id=".$userid);
    $conn->query("INSERT INTO take_outs (userid,repositryid,free) VALUES ('".$userid."','".$_POST['repositoryid']."','1')");
}else{
    $conn->query("INSERT INTO take_outs (userid,repositryid,free) VALUES ('".$userid."','".$_POST['repositoryid']."','0')");
}

$conn->query("UPDATE repositories SET amount=".($amount-1)." WHERE id=".$_POST['repositoryid']);

echo true;
?>