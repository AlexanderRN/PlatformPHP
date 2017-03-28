<?php
session_start();
//error_reporting(0);
include '../ressources/db/dbconfig.php';

$username = $_SESSION['username'];

if (isset($_POST['titel']) && isset($_POST['tekst'])) {
    $conn = new mysqli($servername, $dbuser, $dbpass, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $Titel = $_POST['titel'];
    $Tekst = $_POST['tekst'];


    $stmt = $conn->prepare("INSERT INTO artikler (titel, tekst) VALUES (?, ?)");
    $stmt->bind_param("ss", $Titel, $Tekst);

    $stmt->execute();
    $stmt->close();
    
    $conn->close();
    header("Location: forum.php");
}
