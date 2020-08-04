<?php 
    if(isset($_GET["team_id"])){
        $teamId=$_GET["team_id"];
        
        include 'config.php';

        $sql = "SELECT * FROM player where team_id='$teamId'";
        $myArray = array();
        if ($result = $conn->query($sql)) {
        
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    $myArray[] = $row;
            }
            echo json_encode($myArray);
        }
        
        $result->close();
    }
?>