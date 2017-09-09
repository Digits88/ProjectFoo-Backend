
<html>
<?php
  	$name = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $auth = rand(100000,999999);
    if($name == "" || $firstname == ""){
      echo "<html><body><meta http-equiv='refresh' content='0; URL=./user.php'></body></html>";
      return;
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
    $result = $conn->query("SELECT * FROM users WHERE authcode='".$auth."'");
    do{
        $auth = rand(100000,999999);

        $result = $conn->query("Select * from users where authcode='".$auth."';");
    }while($result == false);
    $result = $conn->query("Insert into users (name,firstname,authcode,matecoins) values ('".$name."','".$firstname."','".$auth."','4');");
?>
<head><meta http-equiv="refresh" content="0; URL=./user.php"></head>
</html>
