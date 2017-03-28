<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Platform</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!--<link rel="stylesheet" type="text/css" href="css/bootstrap.css">-->
    <link rel="stylesheet" type="text/css" href="https://bootswatch.com/sandstone/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/mycss.css?<?php echo time(); ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
</head>
<body>
<?php

include 'navbar.php';

include '../ressources/db/dbconfig.php';
$conn = new mysqli($servername, $dbuser, $dbpass, $dbname);
mysqli_set_charset($conn, "utf8");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$postnummer = null;
if (isset($_POST["search"])) {
    $postnummer = $_POST["search"];
};

if ($postnummer == null) {
    $sql = "SELECT * FROM profiles INNER JOIN profiles_fag ON profiles_fag.profil_id = profiles.profil_id INNER JOIN faggruppe ON faggruppe.fag_id = profiles_fag.fag_id WHERE fagtitel = 'Elektriker' GROUP BY profiles.profil_id";
} else {
    $sql = "SELECT * FROM profiles WHERE Postnummer='" . $postnummer . "' INNER JOIN profiles_fag ON profiles_fag.profil_id = profiles.profil_id INNER JOIN faggruppe ON faggruppe.fag_id = profiles_fag.fag_id";
}

$result = $conn->query($sql);

echo '<div class="container" id="background"><h4>Viser al hjælp omkring: ' . $postnummer . '</h4>';

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        if ($row['Email'] != '' && $row['Fornavn'] != '' && $row['Pris'] != 0 && $row['Postnummer'] != 0 && $row['Arbejdstid'] != '') {
            echo '<div class="row profile-frame" id="profile-frame"> 
                    <input type="hidden" id="profil-id" value="' . $row['profil_id'] . '">
                    <div class="row profil-row-one">
                         <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-2">
                                    <img id="currentPhoto" class="img-circle" src="' . $row["Billede"] . '" onerror="this.src=\'images/no-image-icon-md.png\'" width="100px" height="100px">
                                </div>
                                <div class="col-md-10">
                                    <h3 class="profil-navn">' . $row["Fornavn"] . ' ' . $row["Efternavn"] . '</h3>
                                    <p>' . $row["Pris"] . ' kr. / timen' . ' <span  style="margin-left: 40px;" class="glyphicon glyphicon-map-marker"></span> ' . $row["Bynavn"] . ', ' . $row["Postnummer"] . '<span  style="margin-left: 40px;" class="glyphicon glyphicon-map-marker"></span>' . $row["fagtitel"];
            if ($row["CV"] != "") {
                echo '<a href="' . $row["CV"] . '" style="margin-left: 40px;" target="_blank"><span class="glyphicon glyphicon-paperclip"></span> CV</a>';
            };
            echo '</p>
                                </div>
                            </div>
                         </div>
                         <div class="col-md-5">
                             <h4><strong>Kontakt:</strong></h4>
                             <p class="profil-kontakt-mail">Email: ' . $row["Email"] . '</p>
                             <p class="profil-kontakt-tlf">Telefon: ' . $row["Tlf"] . '</p>
                         </div>
                    </div>
                    <div class="row profil-row-two">
                         <div class="col-md-7"> 
                            <h4><strong>Kort beskrivelse:</strong></h4>
                            <p>' . $row["Beskrivelse"] . '' . '</p>
                         </div>
                         <div class="col-md-5"> 
                            <h4><strong>Arbejdstid:</strong></h4>
                            <p>' . $row["Arbejdstid"] . '</p>
                         </div>
                    </div>
                </div>';
        }
    }
} else {
    echo '<td colspan="6" style="text-align: center;"><strong>Desværre, 0 resultater fundet under det givne postnummer!</strong></td>';
}
echo '</div>';

$conn->close();

?>

<script>
    $(".profile-frame").click(function(){
        document.location = 'details.php?profile=' + $(this).find('#profil-id').val();
    });
</script>
</body>
</html>
