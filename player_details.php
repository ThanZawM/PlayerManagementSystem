<!DOCTYPE html>
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
      <h3>Players Details</h3>
      <br>
    <table class="table table-striped">
    <tr>
        <th>No</th><th>Player</th><th>From_Team</th><th>To_Team</th><th>Date</th><th>Transfer_Fee</th>
    </tr>
    <?php
        include 'config.php';
        $player_id = $_REQUEST['btn_details'];
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT p.player_name, th.transfer_fee,from_team.team_name AS FromTeam, to_team.team_name AS ToTeam,th.date 
            FROM TRANSFER_HISTORY th LEFT JOIN TEAM from_team ON th.from_team_id=from_team.id 
            INNER JOIN PLAYER p ON th.player_id=p.id and th.player_id=$player_id LEFT JOIN TEAM to_team ON th.to_team_id=to_team.id;";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $i=0;
            while($row = $result->fetch_assoc()){
                $i++;
                echo "<tr>";
                echo "<td>$i</td><td>{$row['player_name']}</td><td>{$row['FromTeam']}</td><td>{$row['ToTeam']}</td><td>{$row['date']}</td><td>{$row['transfer_fee']}</td>";
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

