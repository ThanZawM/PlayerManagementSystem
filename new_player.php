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
        
        //echo 'Connection  Name: '.$servername;
        function uploadFile($fileName){
            $target_dir = "images/";
            $target_file = $target_dir . basename($_FILES[$fileName]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            $check = getimagesize($_FILES[$fileName]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } 
            else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES[$fileName]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } 
            else {
                if (move_uploaded_file($_FILES[$fileName]["tmp_name"], $target_file)) {
                    //echo "The file ". basename( $_FILES["photo"]["name"]). " has been uploaded.";
                    return $_FILES[$fileName]["name"];
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            include 'config.php';
            $photo= uploadFile("photo");
            $name=test_input($_POST["name"]);
            $age = test_input($_POST["age"]);
            $salary = test_input($_POST["salary"]);
            $team = test_input($_POST["team"]);
            $country = test_input($_POST["country"]);
            saveItem($name, $photo, $age, $salary, $team, $country);
        }
        function saveItem($name, $photo, $age, $salary, $team, $country){
            global $conn;
            //$sql = "INSERT INTO player(player_name, image_path, age, salary, team_id, country_id) VALUES('$name', '$photo', '$age', '$salary', '$team', '$country');";
            $sql = "insert into player (player_name, image_path, age, salary, team_id, country_id) values(?,?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $name, $photo, $age, $salary, $team, $country);
            $stmt->execute();
            $stmt->close();
            header("Location: player_list.php");
        }

        /*
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
        */  
    ?>
    <?php 
    include 'menu.html';
    ?>
<br>
<h3>Add New Player</h3>
<form method="post" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
<table class="table">
<tr>
    <td>Name</td>
    <td><input name="name" type="text"> </td>
</tr>
<tr>
    <td>Photo</td>
    <td><input type="file" class="form-control" id="photo"  name="photo" /></td>
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