<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: login.php");
    exit;
}
?>

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

            function test_input($data) {
              $data = trim($data);
              $data = stripslashes($data);
              $data = htmlspecialchars($data);
              return $data;
          }

          //For deleting table records
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                if(isset($_REQUEST["player_id"])){
                          include 'config.php';
                          $player_id = test_input($_REQUEST["player_id"]);
                          $sql = "DELETE FROM player WHERE $player_id=id";
                      
                          if ($conn->query($sql) === TRUE) {
                            echo "Deleted successfully";
                          }
                          else {
                            echo "Error deleting table records: " . $conn->error;
                          }
                          $conn->close(); 
                      }
            }
          ?>
          <div class="container">
            <br>
            <h3>Player Information</h3>
            <br>
            <form action="#" method="GET">
            <select name="selected_team_id">
                            <?php
                            include 'config.php';
                            $sql = "SELECT * FROM team;";
                            $result = $conn->query($sql);
                            if($result->num_rows > 0){
                                    while($row = $result->fetch_assoc()){
                                      echo "<option value='" . $row['id'] ."'>" . $row['team_name']."</option>";
                                    }
                                }
                                else{
                                    echo "0 results.";
                                }
                                $conn->close();
                            ?>
              </select>
              <input type="search" name="search_item" placeholder="Search player...">&nbsp;&nbsp;
              <button type="submit" name="btn_search" class="btn btn-outline-info">Search</button>
              <?php
              for($i=0; $i<124; $i++){
                echo "&nbsp";
              }
              ?>
              <button type="submit" class="btn btn-primary" formaction="new_player.php">Add New Player</button>
            </form>
            <br><br>
            <table class="table table-striped">
            <tr>
              <th>No</th><th>Name</th><th>Photo</th><th>Age</th><th>Salary</th><th>Team</th><th>Country</th><th>Details</th><th>Edit</th><th>Delete</th>
            </tr>
            <?php
                  include 'config.php';
                  if(isset($_REQUEST['selected_team_id']) && $_REQUEST['search_item']==""){
                        $selected_team_id = $_REQUEST['selected_team_id'];
                        $sql = "SELECT p.id, p.player_name, p.image_path, p.age, p.salary, t.team_name, c.country_name 
                            FROM player p, team t, country c
                            WHERE p.team_id=$selected_team_id AND p.team_id=t.id AND p.country_id=c.id;";
                  }
                  elseif(isset($_REQUEST['selected_team_id']) && isset($_REQUEST['search_item'])){
                      $search_item = $_REQUEST['search_item'];
                      $selected_team_id = $_REQUEST['selected_team_id'];
                      $sql = "SELECT p.id, p.player_name, p.image_path, p.age, p.salary, t.team_name, c.country_name 
                          FROM player p, team t, country c
                          WHERE p.team_id=$selected_team_id AND p.player_name LIKE '$search_item%' AND p.team_id=t.id AND p.country_id=c.id;";
                  }
                  else{
                    $sql = "SELECT p.id, p.player_name, p.image_path, p.age, p.salary, t.team_name, c.country_name 
                          FROM player p, team t, country c
                          WHERE p.team_id=t.id AND p.country_id=c.id;";
                  }
                  $result = $conn->query($sql);

                  if ($result->num_rows > 0) {
                    $i=0;
                    while($row = $result->fetch_assoc()){
                      $i++;
                        echo "<form action='#' method='GET'>";
                        echo "<tr>";
                        echo "<td>{$i}</td><td>{$row['player_name']}</td>".
                        "<td><img width='50' height='50' src='images/".$row['image_path']."'></td>".
                        "<td>{$row['age']}</td><td>{$row['salary']}</td><td>{$row['team_name']}</td>".
                        "<td>{$row['country_name']}</td>".
                        "<td><button type='submit' class='btn btn-info' name='btn_details' value={$row['id']} formaction='player_details.php'>Details</button></td>".
                        "<td><button type='submit' class='btn btn-success' name='btn-update' value={$row['id']} formaction='update.php'>Update</button></td>".
                        "<td><input type='hidden' name='player_id' value={$row['id']}>".
                        "<button type='submit' class='btn btn-danger' name='btn-delete' onClick=\"javascript: return confirm('Are you sure you want to delete?');\"  formaction={$_SERVER['PHP_SELF']}>Delete</button></td>";
                        echo "</tr>";
                        echo "</form>";
                    }
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

