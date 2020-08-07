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
            include 'config.php';
            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

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

            $player_id = $player_name = $photo = $age = $salary = $team = $country = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                //include 'config.php';
                $photo = uploadFile("photo");
                $player_id = test_input($_REQUEST["player_id"]);
                $input_player_name = test_input($_REQUEST["input_player_name"]);
                $age = test_input($_REQUEST["age"]);
                $salary = test_input($_REQUEST["salary"]);
                $team = test_input($_REQUEST["team"]);
                $country = test_input($_REQUEST["country"]);
               
                $sql = "UPDATE player SET player_name='$input_player_name', image_path='$photo', age=$age, salary=$salary, team_id=$team, country_id=$country WHERE id=$player_id;";
            
                if ($conn->query($sql) === TRUE) {
                    echo "Update successfully";
                    header("location: player_list.php");
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
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
            <?php
                    if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    $player_id = test_input($_REQUEST["btn-update"]);                     
                    $sql = "SELECT p.country_id, p.team_id, p.id, p.player_name, p.image_path, p.age, p.salary, team.team_name, country.country_name
                            FROM player p, team, country 
                            WHERE p.id=$player_id AND p.team_id=team.id AND p.country_id=country.id;";
                    $result = $conn->query($sql);
                    $row = $result->fetch_assoc();
                    $country_id = $row['country_id'];
                    echo "<input type='hidden' name='player_id' value={$row['id']}>";
                    $conn->close();
                    }
            ?>
            <table class="table">
                <tr>
                    <td>Name</td>
                    <td><input type="text" name="input_player_name" value="<?php echo $row['player_name']?>"></td>
                </tr>
                <tr>
                    <td>Photo</td>
                    <td><img width='50' height='50' src="images/{$row['image_path']}"><input type="file" class="form-control" id="photo"  name="photo" ></td>
                </tr>
                <tr>
                    <td>Age</td>
                    <td><input name="age" type="number" value="<?php echo $row['age']?>"> </td>
                </tr>
                <tr>
                    <td>Salary</td><br>
                    <td><input name="salary" type="number" value="<?php echo $row['salary']?>"></td>
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