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
    <div class="container">
        <?php
            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

            $player_id = $player_name = $age = $salary = $team = $country = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if(isset($_REQUEST['btn_update'])){
                    echo "hello update<br>";
                }
                echo "hello<br>";
                $player_id = test_input($_POST["player_id"]);
                $player_name = test_input($_REQUEST["player_name"]);
                $age = test_input($_POST["age"]);
                $salary = test_input($_POST["salary"]);
                $team = test_input($_POST["team"]);
                $country = test_input($_POST["country"]);
                include 'config.php';
                $sql = "UPDATE PLAYER SET player_name=$player_name, age=$age, salary=$salary, team_id=$team, country_id=$country
                        WHERE id=$player_id;";
            
                if ($conn->query($sql) === TRUE) {
                    echo "Update successfully";
                }
                else {
                    echo "Error updating table records: " . $conn->error;
                }
                $conn->close();
            }  
        ?>
        <?php 
        include 'menu.html';
        ?>
        <br>
        <h3>Update Player</h3>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
            <?php
                    include 'config.php';
                    $sql = "SELECT p.country_id, p.team_id, p.id, p.player_name, p.age, p.salary, team.team_name, country.country_name
                            FROM player p, team, country 
                            WHERE p.id=$player_id AND p.team_id=team.id AND p.country_id=country.id;";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $country_id = $row['country_id'];
                    echo "<input type='hidden' name='player_id' value={$row['id']}>";
                    $conn->close();
            ?>
            <table class="table">
                <tr>
                    <td>Name</td>
                    <td><input type="text" name="player_name" value="<?php echo $row['player_name']?>"> </td>
                </tr>
                <tr>
                    <td>Age</td>
                    <td><input name="age" type="number" value="<?php echo $row['age']?>"> </td>
                </tr>
                <tr>
                    <td>Salary</td><br>
                    <td><input name="salary" type="number" value="<?php echo $row['salary']?>"> </td>
                </tr>
                <tr>
                    <td>Team</td><br>
                    <td> 
                        <select name="team">
                            <?php
                                include 'config.php';
                                $sql = "SELECT * FROM team where id={$row['team_id']};";
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
                    </td>
                </tr>
                <tr>
                    <td>Country</td><br>
                    <td>
                        <select name="country">
                            <?php
                                include 'config.php';
                                $sql = "SELECT * FROM country where id=$country_id;";
                                $result = $conn->query($sql);
                                if($result->num_rows > 0){
                                    while($row = $result->fetch_assoc()){
                                    echo "<option value='" . $row['id'] ."'>" . $row['country_name']."</option>";
                                    }
                                }
                                else{
                                    echo "0 results.";
                                }
                                $conn->close();
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><button type="submit" name="btn_update" class="btn btn-primary">Update</button></td>
                </tr>
            </table>
        </form>
    </div>
    </body>
</html>