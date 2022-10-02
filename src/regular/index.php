<?php
$test = 'regular_main.php redirected!!!';
var_dump($test);


include '../connect.php';
$conn = OpenCon();
session_start();

function ShowMyAssignment($conn) {
    $sql = "SELECT `Calendar`.`UID`, `Calendar`.`TableID`, `Calendar`.`Date`, `Table`.`F_updown`, `Table`.`F_monitor`,`Table`.`F_vr_setup`, `Table`.`Floor`,`Table`.`Section`
FROM `Calendar` INNER JOIN `User` ON `User`.`UID` = `Calendar`.`UID` INNER JOIN `Table` ON `Table`.`TableID` = `Calendar`.`TableID`";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {

            echo "<div value=" . $row["city"];
            if (isset($_GET['Vcity'])) {
                if ($_GET['Vcity'] == $row["city"]) {
                    echo " selected='selected'";
                }
            }
            echo ">" . $row["city"] . "</div>";
//
        }
    }
}




