<!DOCTYPE html>
<html>
<head>
    <title>Project</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/mycss.css?<?php echo time(); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
</head>
<body>
<?php

include 'navbar.php';

include '../ressources/db/dbconfig.php';
$conn = new mysqli($servername, $dbuser, $dbpass, $dbname);
mysqli_set_charset($conn,"utf8");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$postnummer = $_POST["search"];

$sql = "SELECT * FROM profiles WHERE Postnummer='" . $postnummer . "'";
$result = $conn->query($sql);

echo '<div class="container"><h4>Viser al hjælp omkring: ' . $postnummer .  '</h4>';

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo
            '<div class="row profile-frame" id="profile-frame">
                 <div>
                     <div class="col-md-2">
                         <img id="currentPhoto" class="img-rounded" src="' . $row["Billede"] . '" onerror="this.src=\'images/no-image-icon-md.png\'" width="80%" height="100%">
                     </div>
                     <div class="col-md-10">
                         <h3 class="profil-navn">' . $row["Fornavn"] . ' ' . $row["Efternavn"] . '</h3>
                         <p>' . $row["Pris"] . ',- / timen' . ' <span  style="margin-left: 40px;" class="glyphicon glyphicon-map-marker"></span> ' . $row["Bynavn"] . ', ' . $row["Postnummer"] . '</p>
                         <p>' . 'Arbejdstid:' . $row["Arbejdstid"] . '</p>
                         <p>' . $row["Beskrivelse"] . '' . '</p>
                         <p class="profil-kontakt">Email: ' . $row["Email"] . ' - Telefon: ' . $row["Tlf"] . '</p>
                     </div>
                 </div>
            </div>';
    }
} else {
    echo '<td colspan="6" style="text-align: center;"><strong>Desværre, 0 resultater fundet under det givne postnummer!</strong></td>';
}
echo '</tbody>
        </table>
    </div>';

$conn->close();

?>
</body>
</html>
