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
    <script>
        $(document).ready(function(){
            $("#fromteamid").change(function(){
                if($("#fromteamid").val()!=""){
                    var teamId=this.value;
                
                $.get("player.php?team_id="+teamId, function(data, status){
        
            var tspList=JSON.parse(data);
        $("#player").empty();
            tspList.forEach(function(val,i){
                $("#player").append(
                    '<option value="'+val.id+'">'+val.player_name+'</option>'
                );
            });
        });
                }
            });
        });
    </script>
</head>
<div class="container">
<body>
    <?php
    //include 'config.php';
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //insert transfer_history table
            include 'config.php';
            $fromteam = test_input($_POST["fromteam"]);
            $playername = test_input($_POST["player_name"]);
            $toteam = test_input($_POST["toteam"]);
            $transfer_fee = test_input($_POST["transfer_fee"]);
            $sql = "INSERT INTO transfer_history(player_id, from_team_id, to_team_id, transfer_fee) VALUES('$playername', '$fromteam', '$toteam', '$transfer_fee');";
        
        if ($conn->query($sql) === TRUE) {
        echo "Insert successfully";
        }
        else {
        echo "Error creating table: " . $conn->error;
        }
        $conn->close();

        //update player table
        include 'config.php';
        $playername = test_input($_POST["player_name"]);
        $toteam = test_input($_POST["toteam"]);
        $sql = "UPDATE player SET team_id=$toteam WHERE id=$playername;";
        
        if ($conn->query($sql) === TRUE) {
        echo "Update successfully";
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
    
<h3>Transfer Player</h3>
    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
        <table class="table">
            <tr>
                <td>From Team</td><br>
                <td>
                    <select name="fromteam" id="fromteamid">
                            <?php
                                include 'config.php';
                                $sql = "SELECT * FROM team";
                                $region = array();
                                if ($result = $conn->query($sql)) {
                                    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                                            $region[] = $row;
                                    } 
                                }
                                if(count($region)>0){
                                    foreach($region as $r){
                                        echo "<option value='".$r['id']."'>{$r['team_name']}</option>";
                                    }
                                }
                                $conn->close();
                            ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Player</td>
                <td>
                    <select id="player" name="player_name">
                        
                    </select>
                </td>
            </tr>
            <tr>
                <td>To Team</td><br>
                <td>
                    <select name="toteam">
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
                <td>Transfer Fee</td>
                <td><input type='number' name='transfer_fee'></td>
            </tr>
            <tr>
                <td colspan="2"><button type="submit" class="btn btn-primary">Add</button></td>   
            </tr>
        </table>
    </form>
</body>
    </div>
</html>