<?php

session_start();
include '../ressources/db/dbconfig.php';

if (isset($_SERVER['REQUEST_METHOD'])) {
    $conn = new mysqli($servername, $dbuser, $dbpass, $dbname);
    mysqli_set_charset($conn,"utf8");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_SESSION['username'];

    $stmt = $conn->prepare("SELECT user_id FROM users WHERE Email=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();

    $target_dir = "images/uploads/";
    $target_file = $target_dir . basename($_FILES["billede"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image

    $check = getimagesize($_FILES["billede"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    //TJEK OG FIX DETTE SÅ BILLEDE GEMMER OG SIDEN RELOADER SÅ INFORMATIONERNE ER OPDATERET


    $Fornavn = $_POST["fornavn"];
    $Efternavn = $_POST["efternavn"];
    $Email = $_POST["email"];
    $Telefon = $_POST["tlf"];
    $Bynavn = $_POST["bynavn"];
    $Postnummer = $_POST["postnummer"];
    $Pris = $_POST["pris"];
    $Arbejdstid = $_POST["arbejdstid"];

    $stmt->close();

    $stmt = $conn->prepare("INSERT INTO profiles (user_id, Fornavn, Efternavn, Email, Tlf, Bynavn, Postnummer, Pris, Arbejdstid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE user_id = VALUES(user_id), Fornavn = VALUES(Fornavn), Efternavn = VALUES(Efternavn),
     Email = VALUES(Email), Tlf = VALUES(Tlf), Bynavn = VALUES(Bynavn), Postnummer = VALUES(Postnummer), Pris = VALUES(Pris), Arbejdstid = VALUES(Arbejdstid)");

    $stmt->bind_param("isssisiis", $user_id, $Fornavn, $Efternavn, $Email, $Telefon, $Bynavn, $Postnummer, $Pris, $Arbejdstid);
    $stmt->execute();
    $stmt->close();

    $conn->close();

  //  header('Location: profile.php');
}

