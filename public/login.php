<?php
session_start();

//error_reporting(0);

include '../ressources/db/dbconfig.php';
$username = $_POST['email'];
$password = $_POST['password'];

if($username&&$password) {

    // Create connection
    $conn = new mysqli($servername, $dbuser, $dbpass, $dbname);


    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //$query = mysqli_query($conn, "SELECT * FROM users INNER JOIN profiles ON users.user_id = profiles.user_id WHERE Username='" . $username . "'");
    $query = mysqli_query($conn, "SELECT * FROM users WHERE Username='" . $username . "'");

    $numrows = mysqli_num_rows($query);

    if($numrows > 0) {
        while($row = mysqli_fetch_assoc($query)){
            $dbusername = $row['Username'];
            $dbpassword = $row['Password'];

            if($username == $dbusername && password_verify($password, $dbpassword)) {
                $_SESSION['username'] = $username;
                $_SESSION['navn'] = $row['Fornavn'] . ' ' . $row['Efternavn'];
                $_SESSION['loginError'] = "";
                header("Location: profile.php");
                die();
            } else {
                $_SESSION['loginError'] = "Wrong password or username.";
                header("Location: index.php");
                die();
            }
        }
    } else {
        $_SESSION['loginError'] = "Wrong password or username.";
        header("Location: index.php");
        die();
    }


} else {
    $_SESSION['loginError'] = "You need to type your username and password.";
    header("Location: index.php");
    die();
}

?>