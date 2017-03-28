<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Platform</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!--<link rel="stylesheet" type="text/css" href="css/bootstrap.css">-->
    <link rel="stylesheet" type="text/css" href="https://bootswatch.com/sandstone/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/mycss.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
</head>
<body>
<?php
include 'navbar.php';
$pID = htmlspecialchars($_GET["profile"]);

include '../ressources/db/dbconfig.php';

$conn = new mysqli($servername, $dbuser, $dbpass, $dbname);
mysqli_set_charset($conn, "utf8");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM profiles WHERE profil_id ='" . $pID . "'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $Fornavn = $row["Fornavn"];
        $Efternavn = $row["Efternavn"];
        $Email = $row["Email"];
        $Telefon = $row["Tlf"];
        $Bynavn = $row["Bynavn"];
        $Postnummer = $row["Postnummer"];
        $Pris = $row["Pris"];
        $Arbejdstid = $row["Arbejdstid"];
        $Beskrivelse = $row["Beskrivelse"];
        $Billede = $row["Billede"];
    }
}
?>
<div class="container">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h2 style="font-size: 25px; text-align: center" class="panel-title"><?php echo $Fornavn . ' ' . $Efternavn ?></h2>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="<?php echo $Billede?>" onerror="this.src='images/no-image-icon-md.png'" class="img-rounded img-responsive"> </div>
                <div class=" col-md-9 col-lg-9 ">
                    <table class="table table-user-information">
                        <tbody>
                        <tr>
                            <td>Department:</td>
                            <td>Programming</td>
                        </tr>
                        <tr>
                            <td>Hire date:</td>
                            <td>06/23/2013</td>
                        </tr>
                        <tr>
                            <td>Date of Birth</td>
                            <td>01/24/1988</td>
                        </tr>

                        <tr>
                        </tr><tr>
                            <td>By og postnummer</td>
                            <td><?php echo $Bynavn . ', ' . $Postnummer ?></td>
                        </tr>
                        <tr>
                            <td>Home Address</td>
                            <td>Kathmandu,Nepal</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><a href="<?php echo $Email ?>"><?php echo $Email ?></a></td>
                        </tr>
                        <tr><td>Phone Number</td>
                            <td><?php echo $Telefon ?></td>
                        </tr>
                        </tbody>
                    </table>

                    <a href="#" class="btn btn-primary">Besøg <?php echo $Fornavn?>'s hjemmeside!</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>