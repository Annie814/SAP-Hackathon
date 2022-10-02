<?php
session_start();
require '../connect.php';

$conn = OpenCon();

$utility = $_POST['utility'];
$floor = $_POST['floor'];


if (isset($_POST['alltables'])){
    $division = $_POST['alltables'];
} else {
    $division = "";
}
    if ($utility =='' && $floor ==''){
        header("location:testing_centres.php?Division=".$division);
    }
    if ($utility =='' && $floor !=''){
        header("location:testing_centres.php?Vkinds=".$floor.'&Division='.$division);
    }
    if ($utility !='' && $floor ==''){
        header("location:testing_centres.php?Vcity=".$utility.'&Division='.$division);
    }
    if ($utility !='' && $floor !=''){
        header("location:testing_centres.php?Vcity=".$utility.'&Vkinds='.$floor.'&Division='.$division);

    }



CloseCon($conn);


