<?php

session_start();
include '../ressources/db/dbconfig.php';

if (isset($_SERVER['REQUEST_METHOD'])) {
    $conn = new mysqli($servername, $dbuser, $dbpass, $dbname);
    mysqli_set_charset($conn, "utf8");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_SESSION['username'];

    $stmt = $conn->prepare("SELECT user_id FROM users WHERE Username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();

    $target_dirBillede = "images/uploads/";
    $target_dirCV = "images/uploads/cv/";

    $target_fileBillede = null;
    $target_fileCV = null;

    if (isset($_FILES["billede"])) {
        $target_fileBillede = $target_dirBillede . basename($_FILES["billede"]["name"] . $username);
    }
    if (isset($_FILES["cv"])) {
        $target_fileCV = $target_dirCV . basename($_FILES["cv"]["name"] . $username);
    }

    if (move_uploaded_file($_FILES['billede']['tmp_name'], $target_fileBillede)) {
        echo "File is valid, and was successfully uploaded.\n";
    } else {
        echo "Upload failed";
    }
    if (move_uploaded_file($_FILES['cv']['tmp_name'], $target_fileCV)) {
        echo "File is valid, and was successfully uploaded.\n";
    } else {
        echo "Upload failed";
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
    $Beskrivelse = $_POST["beskrivelse"];
    $Billede = $target_fileBillede;
    $CV = $target_fileCV;

    $stmt->close();

    if ($Billede == null && $CV == null) {
        $stmt = $conn->prepare("INSERT INTO profiles (user_id, Fornavn, Efternavn, Email, Tlf, Bynavn, Postnummer, Pris, Arbejdstid, Beskrivelse) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE user_id = VALUES(user_id), Fornavn = VALUES(Fornavn), Efternavn = VALUES(Efternavn),
         Email = VALUES(Email), Tlf = VALUES(Tlf), Bynavn = VALUES(Bynavn), Postnummer = VALUES(Postnummer), Pris = VALUES(Pris), Arbejdstid = VALUES(Arbejdstid), Beskrivelse = VALUES(Beskrivelse)");
        $stmt->bind_param("isssisiiss", $user_id, $Fornavn, $Efternavn, $Email, $Telefon, $Bynavn, $Postnummer, $Pris, $Arbejdstid, $Beskrivelse);
    } else if ($Billede != null && $CV == null) {
        $stmt = $conn->prepare("INSERT INTO profiles (user_id, Fornavn, Efternavn, Email, Tlf, Bynavn, Postnummer, Pris, Arbejdstid, Billede, Beskrivelse) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE user_id = VALUES(user_id), Fornavn = VALUES(Fornavn), Efternavn = VALUES(Efternavn),
         Email = VALUES(Email), Tlf = VALUES(Tlf), Bynavn = VALUES(Bynavn), Postnummer = VALUES(Postnummer), Pris = VALUES(Pris), Arbejdstid = VALUES(Arbejdstid), Billede = VALUES(Billede), Beskrivelse = VALUES(Beskrivelse)");
        $stmt->bind_param("isssisiisss", $user_id, $Fornavn, $Efternavn, $Email, $Telefon, $Bynavn, $Postnummer, $Pris, $Arbejdstid, $Billede, $Beskrivelse);
    } else if ($CV != null && $Billede == null) {
        $stmt = $conn->prepare("INSERT INTO profiles (user_id, Fornavn, Efternavn, Email, Tlf, Bynavn, Postnummer, Pris, Arbejdstid, CV, Beskrivelse) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE user_id = VALUES(user_id), Fornavn = VALUES(Fornavn), Efternavn = VALUES(Efternavn),
         Email = VALUES(Email), Tlf = VALUES(Tlf), Bynavn = VALUES(Bynavn), Postnummer = VALUES(Postnummer), Pris = VALUES(Pris), Arbejdstid = VALUES(Arbejdstid), CV = VALUES(CV), Beskrivelse = VALUES(Beskrivelse)");
        $stmt->bind_param("isssisiisss", $user_id, $Fornavn, $Efternavn, $Email, $Telefon, $Bynavn, $Postnummer, $Pris, $Arbejdstid, $CV, $Beskrivelse);
    } else {
        $stmt = $conn->prepare("INSERT INTO profiles (user_id, Fornavn, Efternavn, Email, Tlf, Bynavn, Postnummer, Pris, Arbejdstid, Billede, CV, Beskrivelse) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE user_id = VALUES(user_id), Fornavn = VALUES(Fornavn), Efternavn = VALUES(Efternavn),
     Email = VALUES(Email), Tlf = VALUES(Tlf), Bynavn = VALUES(Bynavn), Postnummer = VALUES(Postnummer), Pris = VALUES(Pris), Arbejdstid = VALUES(Arbejdstid), Billede = VALUES(Billede), CV = VALUES(CV), Beskrivelse = VALUES(Beskrivelse)");
        $stmt->bind_param("isssisiissss", $user_id, $Fornavn, $Efternavn, $Email, $Telefon, $Bynavn, $Postnummer, $Pris, $Arbejdstid, $Billede, $CV, $Beskrivelse);
    }

    $stmt->execute();
    $stmt->close();

    $conn->close();

    //  header('Location: profile.php');
}

