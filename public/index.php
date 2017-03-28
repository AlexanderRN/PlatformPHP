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
    <div class="jumbotron">
        <h1>Velkommen til ---!</h1>
        <p>Denne side er designet for at kunne ...</p>
        <div class="text-right">
            <p><a class="btn btn-primary btn-lg" href="#" role="button">Læs mere</a></p>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h4>Indtast dit postnummer og vi finder den nærmeste hjælp:</h4>
            <form class="form-inline" method="POST" action="list.php">
                <input type="text" style="width: 80%" placeholder="2600" name="search" class="form-control">
                <input type="submit" style="width: 18%" name="searchBtn" class="btn btn-primary" value="Søg">
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>

</body>
</html>