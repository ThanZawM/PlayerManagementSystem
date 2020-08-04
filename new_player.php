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
    //include 'config.php';
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            include 'config.php';

            $name = test_input($_POST["name"]);
            $age = test_input($_POST["age"]);
            $salary = test_input($_POST["salary"]);
            $team = test_input($_POST["team"]);
            $country = test_input($_POST["country"]);
            $sql = "INSERT INTO player(player_name, age, salary, team_id, country_id) VALUES('$name', '$age', '$salary', '$team', '$country');";
        
        if ($conn->query($sql) === TRUE) {
        echo "Insert successfully";
        }
        else {
        echo "Error creating table: " . $conn->error;
        }
        $conn->close();
    }  
    ?>
    <?php 
    include 'menu.html';
    ?>
<br>    
<h3>Add New Player</h3>
<form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
<table class="table">
<tr>
    <td>Name</td>
    <td><input name="name" type="text"> </td>
</tr>
<tr>
    <td>Age</td>
    <td><input name="age" type="number"> </td>
</tr>
<tr>
    <td>Salary</td><br>
    <td><input name="salary" type="number"> </td>
</tr>
<tr>
    <td>Team</td><br>
    <td>
        <select name="team">
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
    </td>
</tr>
<tr>
    <td>Country</td><br>
    <td>
        <select name="country">
                <?php
                  include 'config.php';
                  $sql = "SELECT * FROM country;";
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
    <td colspan="2"><button type="submit" class="btn btn-primary">Add</button></td>
</tr>
</table>
</form>
</div>
</body> 
</html>