<?php
session_start();
error_reporting(0);
include '../ressources/db/dbconfig.php';
if (isset($_POST['newemail']) && isset($_POST['newpassword'])) {
    $conn = new mysqli($servername, $dbuser, $dbpass, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $User = $_POST['newemail'];
    $Pass = $_POST['newpassword'];
    $Pass = password_hash($Pass, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (Username, Password)
        VALUES ('$User', '$Pass')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['username'] = $User;
        header("Location: profile.php"); // Redirecting To profile Page
    } else if ($conn->errno == 1062){
        $_SESSION['loginError'] = "Username already taken.";
        header("Location: index.php"); // Redirecting To Home Page
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        echo $conn->errno;
    }

    $conn->close();
}
