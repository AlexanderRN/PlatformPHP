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
<?php include 'navbar.php'; ?>
<div class="container">
    <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-2"></div>
        <div class="col-md-5">
            <h4>Søg efter en artikel:</h4>
            <form class="form-inline" method="POST" action="list.php">
                <input type="text" style="width: 80%" placeholder="Elektriker søges til stort projekt..." name="search"
                       class="form-control">
                <input type="submit" style="width: 18%" name="searchBtn" class="btn btn-primary" value="Søg">
            </form>
        </div>
        <div class="col-md-3">
            <h4>Eller opret en artikel:</h4>
            <input type="button" style="width: 100%;" class="btn btn-success" data-toggle="modal"
                   data-target="#opretArtikelModal" value="Opret artikel">
        </div>
        <div class="col-md-2"></div>
    </div>
    <div class="row">
        <?php
        include '../ressources/db/dbconfig.php';
        $conn = new mysqli($servername, $dbuser, $dbpass, $dbname);
        mysqli_set_charset($conn, "utf8");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM artikler";


        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                    echo '<div class="row artikel-frame" id="artikel-frame">
                        <input type="hidden" id="artikel-id" value="' . $row['artikel_id'] . '">
                        <div class="col-md-5">
                             <h4><strong>' . $row["titel"] . '</strong></h4>
                             <p>' . $row["tekst"] . '</p>
                        </div>
                    </div>';
                }
        } else {
            echo '<td colspan="6" style="text-align: center;"><strong>Desværre, ingen artikler fundet!</strong></td>';
        }
        echo '</div>';

        $conn->close();
        ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="opretArtikelModal" tabindex="-1" role="dialog" aria-labelledby="opretArtikelModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true"></span></button>
                <h4 class="modal-title" id="exampleModalLabel">Opret en artikel</h4>
            </div>
            <div class="modal-body">
                <form id="artikelForm" action="opretArtikel.php" method="POST">
                    <div class="form-group">
                        <label for="titel" class="control-label">Titel:</label>
                        <input type="text" placeholder="Titel" name="titel" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="tekst" class="control-label">Brødtekst:</label>
                        <textarea style="resize: vertical;" rows="4" cols="25" class="form-control" id="tekst" name="tekst" required></textarea>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Luk</button>
                        <input type="submit" name="login" class="btn btn-success" value="Opret">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
