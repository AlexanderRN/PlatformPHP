<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Workling - Profile</title>
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
include '../ressources/db/dbconfig.php';

$conn = new mysqli($servername, $dbuser, $dbpass, $dbname);
mysqli_set_charset($conn, "utf8");

$username = $_SESSION['username'];

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM profiles INNER JOIN users ON profiles.user_id = users.user_id WHERE users.Username ='" . $username . "'";
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
        $_SESSION['navn'] = $row['Fornavn'] . ' ' . $row['Efternavn'];
    }
} else {
    $Fornavn = "";
    $Efternavn = "";
    $Email = "";
    $Telefon = "";
    $Bynavn = "";
    $Postnummer = "";
    $Pris = "";
    $Arbejdstid = "";
    $Beskrivelse = "";
    $Billede = "";
}
echo '</tbody>
        </table>
    </div>';

$conn->close();
?>

<div class="container">
    <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-2">
            <img id="currentPhoto" class="img-rounded" src="<?php echo $Billede; ?>"
                 onerror="this.src='images/no-image-icon-md.png'"
                 width="160px" height="160px">
        </div>
        <div class="col-md-10">
            <?php
            echo '<div class="alert alert-warning" id="warningFieldsEmpty" role="alert">Din profil skal indeholde: Fornavn, Efternavn, Email, Timeløn, Postnummer og Arbejdstider for at blive vist under søgninger!</div>';
            echo '<form  id="profileForm" method="post" action="">
        <div class="form-group" enctype="multipart/form-data">
            <label for="Fornavn">Fornavn</label>
            <input type="text" class="form-control" id="Fornavn" name="Fornavn" placeholder="Fornavn" value="' . htmlspecialchars($Fornavn) . '">
        </div>
        <div class="form-group">
            <label for="Efternavn">Efternavn</label>
            <input type="text" class="form-control" id="Efternavn" name="Efternavn" placeholder="Efternavn" value="' . htmlspecialchars($Efternavn) . '">
        </div>
        <div class="form-group">
            <label for="billedeInput">Upload dit billede her!</label>
            <input type="file" id="billedeInput">
            <p class="help-block">Upload et billede af dig selv her.(PNG, JPG)</p>
        </div>
        <div class="form-group">
            <label for="cvInput">Upload dit cv her!</label>
            <input type="file" id="cvInput">
            <p class="help-block">Upload et cv her.(PDF)</p>
        </div>
        <div class="form-group">
            <label for="Email">Email</label>
            <input type="text" class="form-control" id="Email" name="Email" placeholder="Email" value="' . htmlspecialchars($Email) . '">
        </div>
        <div class="form-group">
            <label for="Tlf">Telefon</label>
            <input type="text" class="form-control" id="Tlf" name="Tlf" placeholder="Telefon" value="' . htmlspecialchars($Telefon) . '">
        </div>
        <div class="form-group">
            <label for="Bynavn">Bynavn</label>
            <input type="text" class="form-control" id="Bynavn" name="Bynavn" placeholder="Bynavn" value="' . htmlspecialchars($Bynavn) . '">
        </div>
        <div class="form-group">
            <label for="Postnummer">Postnummer</label>
            <input type="text" class="form-control" id="Postnummer" name="Postnummer" placeholder="Postnummer" value="' . htmlspecialchars($Postnummer) . '">
        </div>
        <div class="form-group">
            <label for="Pris">Timeløn</label>
            <input type="text" class="form-control" id="Pris" name="Pris" placeholder="Pris" value="' . htmlspecialchars($Pris) . '">
        </div>
        <div class="form-group">
            <label for="Arbejdstid">Arbejdstid</label>
            <textarea rows="4" cols="25" class="form-control" id="Arbejdstid" name="Arbejdstid">' . $GLOBALS['Arbejdstid'] . '</textarea>
        </div>
        <div class="form-group">
            <label for="Beskrivelse">Beskrivelse</label>
            <textarea rows="4" cols="25" class="form-control" id="Beskrivelse" name="Beskrivelse">' . $GLOBALS['Beskrivelse'] . '</textarea>
        </div>
        <input type="submit" id="gemProfil" name="gem" class="btn btn-success" value="Gem" style="display: inline-block; width: 80px; position: absolute;">    
        <div id="success-alert" class="alert alert-success collapse" style="margin-left: 84px; height: 46px;" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                <strong>Profil gemt, vent venligst et øjeblik imens siden genindlæser!</strong>
        </div>
        <br><br>
        </form>';
            ?>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        var placeholder = 'Eksempel: \nHverdage: 16-19 \nLørdage: 08-14 \nSøndage: 11-16';
        $('#Arbejdstid').attr('placeholder', placeholder);

        if ($('#Fornavn').val() != '' && $('#Efternavn').val() != '' && $('#Email').val() != '' && $('#Pris').val() != 0 && $('#Postnummer').val() != 0 && $('#Arbejdstid').val() != '') {
            $('#warningFieldsEmpty').hide();
        }


        $('#gemProfil').click(function (e) {
            // e.preventDefault();

            var formData = false;

            if (window.FormData) formData = new FormData();
            if (formData === false) {
                alert("Your browser does not support form data");
                return false;
            }

            var fornavn = $('#Fornavn').val();
            var efternavn = $('#Efternavn').val();
            var email = $('#Email').val();
            var tlf = $('#Tlf').val();
            var bynavn = $('#Bynavn').val();
            var postnummer = $('#Postnummer').val();
            var pris = $('#Pris').val();
            var arbejdstid = $('#Arbejdstid').val();
            var beskrivelse = $('#Beskrivelse').val();
            var billede = $("#billedeInput")[0];
            var cv = $("#cvInput")[0];

            formData.append("fornavn", fornavn);
            formData.append("efternavn", efternavn);
            formData.append("email", email);
            formData.append("tlf", tlf);
            formData.append("bynavn", bynavn);
            formData.append("postnummer", postnummer);
            formData.append("pris", pris);
            formData.append("arbejdstid", arbejdstid);
            formData.append("beskrivelse", beskrivelse);
            formData.append("billede", billede.files[0]);
            formData.append("cv", cv.files[0]);

            $.ajax({
                type: "POST",
                url: "updateProfile.php",
                data: formData,
                processData: false,  //IMPORTANT when sending formdata
                contentType: false,  //IMPORTANT when sending formdata
                beforeSend: function () {
                    console.log("adding ticket...");
                },
                success: function (data) {
                    if (data == "error") {
                        console.log("Error adding ticket (freshdesk API)...");
                    } else {
                        console.log("ticket added! Ticket number is " + data);
                    }
                    $("#success-alert").offset();
                    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
                        $("#success-alert").slideUp(500);
                        location.reload();
                    });
                },
                error: function () {
                    console.log("error adding ticket (add_ticket.php)...");
                }
            });
            return false;
        });
    });
</script>
</body>
</html>
