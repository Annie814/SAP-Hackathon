<?php
session_start();
require 'connect.php';



function handleLoginRequest($conn) {

    $userid = $_POST['userid'];
    $password = $_POST['password'];
    $_SESSION['userid'] = $userid;
    if (($userid == '') || ($password == '')) {
        header("location:index.html");
        //echo "<br>Email or password cannot be empty. Auto-refresh in 1 second.<br>";
        exit;
    }
    $sql = "SELECT Count(*) FROM User WHERE (User.UID='$userid' and User.Password='$password')";
    $result = mysqli_query($conn, $sql);
    var_dump();
    $num = ($result->fetch_array())[0];

    if ($num == 1) {
        // echo "<br>Logged In Successfully!<br>";
        $result = $conn->query("SELECT UserType FROM User WHERE (User.UID='$userid')");
        $userType = $result->fetch_array()[0];
            if ($userType == 'Regular') {
                echo "You're an Regular User\n";
                header("location:regular/index.php");
            } else {
                echo "You're an Admin User\n";
                header("location:admin/index.php");
            }

    } else if ($num == 0) {
            header("location:index.html");
            //echo "<br>Email or password wrong. Auto-refresh in 1 seconds.<br>";
        }
    # CloseCon($conn);
}


function handlePOSTRequest() {
    $conn = OpenCon();
    if (array_key_exists('login', $_POST)) {

        handleLoginRequest($conn);
    }
    CloseCon($conn);
}

if (isset($_POST['login'])) {
    handlePOSTRequest();
}

