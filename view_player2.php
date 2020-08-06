<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
      <style>
         .a{
           float:right;
           margin-right:100px;
         }
      </style>
    </head>
    <body>
    <?php
            include 'menu.html';

            function test_input($data) {
              $data = trim($data);
              $data = stripslashes($data);
              $data = htmlspecialchars($data);
              return $data;
          }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                include 'config.php';
                $player_id = test_input($_POST["player_id"]);
                $sql = "DELETE FROM player WHERE $player_id=id";
            
                if ($conn->query($sql) === TRUE) {
                echo "Deleted successfully";
                }
                else {
                echo "Error deleting table records: " . $conn->error;
                }
                $conn->close(); 
            }
          ?>
          <div class="container">
            <br>
            <h3><i>Player Information</i></h3>
            
                  
            <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
        <table class="table">
            <br>
            <table class="table">
            <tr>
             <th>No</th> <th>Name</th><th>Age</th><th>Salary</th><th>Team</th><th>Country</th>
            </tr>
            <?php
                  include 'config.php';
                  $sql = "SELECT player.id, player.player_name, player.age, player.salary,team.team_name,country.country_name 
                          FROM player, team, country
                          WHERE player.team_id=team.id AND player.country_id=country.id AND team.id=2;";

                  $result = $conn->query($sql);
                     $i=0;
                  if ($result->num_rows > 0) {
                    echo "<ol start=1>";
                    
                    while($row = $result->fetch_assoc()){
                      $i++;
                        echo "<form action='#' method='post'>";
                        echo "<tr>";
                        echo "<td>{$i}</td><td>{$row['player_name']}</td><td>{$row['age']}</td><td>{$row['salary']}</td><td>{$row['team_name']}</td>".
                        "<td>{$row['country_name']}</td>";
                        //"<td><input type='hidden' name='player_id' value={$row['id']}>".
                        //"<button type='submit' class='btn btn-success' name='btn-update' id='btn-update' formaction='update.php' value={$row['id']}>Update</button></td>".
                       // "<td><input type='hidden' name='player_id' value={$row['id']}>".
                       // "<button type='submit' class='btn btn-danger' name='btn-delete' id='btn-delete' formaction={$_SERVER['PHP_SELF']}>Delete</button></td>";
                        echo "</tr>";
                        echo "</form>";
                    }
                    echo "</ol>";
                  }
                  else{
                    echo "";
                  }
                  
                  $conn->close();
            ?>
                </table>
            </div>
    </body>
</html>

