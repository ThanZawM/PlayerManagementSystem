<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: login.php");
    exit;
}
?>

<DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    </head>
    <body>
      <?php
        include 'menu.html';
      ?>
      
      <br>
      
      <div class="container">
      <h3>Team Information</h3>
      <br>
    <table class="table">
    <tr>
        <th>Team</th><th>Number of Player</th><th></th>
    </tr>
    <?php
        include 'config.php';
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
       $sql="SELECT t.team_name,count(p.team_id) AS cnt FROM team t , player p WHERE p.team_id=1 and p.team_id=t.id;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>{$row['team_name']}</td><td>{$row['cnt']} </td><td><a href='view_player.php'><button>View Player</button></a></td>";
               
                echo "</tr>";
            }
        }
        else {
            echo "";
        }
        $sql1="SELECT t.team_name,count(p.team_id) AS cnt FROM team t , player p WHERE p.team_id=2 and p.team_id=t.id;";
        $result1 = $conn->query($sql1);

        if ($result1->num_rows > 0){
            while($row1 = $result1->fetch_assoc()){
                echo "<tr>";
                echo "<td>{$row1['team_name']}</td><td>{$row1['cnt']} </td><td><a href='view_player2.php'><button>View Player</button></a></td>";
               
                echo "</tr>";
            }
        }
        else {
            echo "";
        }
        $conn->close();
?>        
    </table>
    </div>
    </body>
</html>

