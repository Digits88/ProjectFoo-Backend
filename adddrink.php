
<html>
<?php
  	$name = $_POST['name'];
    $price = $_POST['price'];
    $coin = $_POST['coin'];
    if($name == "" || $price == "" || $coin == ""){
      echo "<html><body><meta http-equiv='refresh' content='0; URL=./drinks.php'></body></html>";
      return;
    }
    if($coin=="Ja"){
      $coin = true;
    }else{
      $coin = false;
    }
    echo $name;
    echo $price;
    echo $coin;

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "foo";
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO drinks (name, price, isCoinable) VALUES ('$name', '$price', '$coin')";
    $conn->query($sql);
?>
<head><meta http-equiv="refresh" content="0; URL=./drinks.php"></head>
</html>
