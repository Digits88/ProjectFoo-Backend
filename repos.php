<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
	 table {margin-top:50px;}
	</style>
  </head>
  <body>



    <!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Team Mettigel - Foo</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="./index.html">Home</a></li>
            <li><a href="./user.php">Userübersicht</a></li>
            <li><a href="./fridge.php">Kühlschrankübersicht</a></li>
            <li><a href="./drinks.php">Getränkeübersicht</a></li>
            <li class="active"><a href="./repos.php">Bestände</a></li>
            <li><a href="./balance.php">Übersicht</a></li>
            <li><a href="https://twitter.com/TeamMettigel">Kontakt</a></li>
            <!---<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>-->
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

    <?php
    error_reporting(0);
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "foo";
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM repositories order by amount asc";
    $result = $conn->query($sql);
    echo "<div class='container'><div class='row'><div class='col-md-6'>";
    echo "<table class='table table-striped' width='1500'>";
    echo "<tr>";
    echo "<td><b>Getränk</b></td>";
    echo "<td><b>Kühlschrank</b></td>";
    echo "<td><b>Menge</b></td>";
    echo "</tr>";
    echo "<tr>";
    echo "</tr>";
    if($result == false){
      die();
    }
    while($row = mysqli_fetch_object($result))
    {
      $resultdrink = $conn->query("SELECT * FROM drinks WHERE id=".$row->drinkid);
      while($drinkrow = mysqli_fetch_object($resultdrink)){
        $resultfridge = $conn->query("SELECT * FROM fridges WHERE id=".$row->fridgeid);
        while($fridgerow = mysqli_fetch_object($resultfridge)){
          echo "<tr>";
          echo "<td>",$drinkrow->name,"</td>";
          echo "<td>",$fridgerow->name,"</td>";
          echo "<td>",$row->amount,"</td>";
          echo "</tr>";
        }
      }
    }
    echo "</table>";
    echo "</div></div></div>";
    ?>

    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <button class="btn bn-sm btn-default" onclick="window.location.href='./addrepo.php'">Add Repository</button>
        </div>
      </div>
    </div>
  </body>
</html>
