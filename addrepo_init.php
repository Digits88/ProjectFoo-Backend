<?php
if($_POST['fridge'] == null || $_POST['drink'] == null || $_POST['amount'] == null){
    die("missing parameter");
}

if(!is_numeric($_POST['amount'])){
    die("invalid parameter");
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
$sql = "SELECT * FROM fridges WHERE name='".$_POST['fridge']."'";
$result = $conn->query($sql);

$fridgeid = -1;
while($row = mysqli_fetch_object($result)){
    $fridgeid = $row->id;
}

$sql = "SELECT * FROM drinks WHERE name='".$_POST['drink']."'";
$result = $conn->query($sql);

$drinkid = -1;
while($row = mysqli_fetch_object($result)){
    $drinkid = $row->id;
}

$result = $conn->query("SELECT * FROM repositorys WHERE drinkid='".$drinkid."' AND fridgeid='".$fridgeid."'");

if($result == false){
    $conn->query("INSERT INTO repositories (drinkid,fridgeid,amount) VALUES ('".$drinkid."','".$fridgeid."','".$_POST['amount']."')");
}else{
    $conn->query("UPDATE repositories SET amount=".$_POST['amount']." WHERE drinkid=".$drinkid." AND fridgeid=".$fridgeid);
}
?>

<head><meta http-equiv="refresh" content="0; URL=./repos.php"></head>