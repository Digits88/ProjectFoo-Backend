<?php
header("Access-Control-Allow-Origin: *");
if($_POST['message'] != "are you there?"){
    die("invalid parameter");
}
echo "yes";
?>
