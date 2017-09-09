
<html>
<?php
function generateRandomString($length) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

  	$name = $_POST['name'];
    $place = $_POST['place'];
    if($name == "" || $place == ""){
      echo "<html><body><meta http-equiv='refresh' content='0; URL=./fridge.php'></body></html>";
      return;
    }
    $identifier = generateRandomString(12);

    echo $name;
    echo $place;
    echo $identifier;

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "foo";
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
      $result = $conn->query("SELECT * FROM fridges WHERE identifier='",$identifier,"'");
    while($result->num_rows == 1){
      $identifier = generateRandomString(12);
      $result = $conn->query("SELECT * FROM fridges WHERE identifier='",$identifier,"'");
    }

    $sql = "INSERT INTO fridges (identifier, name, location) VALUES ('$identifier', '$name', '$place')";
    $conn->query($sql);
?>
<head><meta http-equiv="refresh" content="0; URL=./fridge.php"></head>
</html>
