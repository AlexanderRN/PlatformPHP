<?php
session_start();
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

    $sql = "INSERT INTO users (Email, Password)
        VALUES ('$User', '$Pass')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['loginError'] = "User created!";
        header("Location: index.php"); // Redirecting To Home Page
    } else if ($conn->errno == 1062){
        $_SESSION['loginError'] = "Username already taken.";
        header("Location: index.php"); // Redirecting To Home Page
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        echo $conn->errno;
    }

    $conn->close();
}
