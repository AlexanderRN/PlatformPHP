<?php
session_start();

echo '<nav class="navbar navbar-inverse navbar-fixed-top">';
echo '<div class="container">';
echo '<div class="navbar-header">';
echo '<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"';
echo 'aria-expanded="false" aria-controls="navbar">';
echo '<span class="sr-only">Toggle navigation</span>';
echo '<span class="icon-bar"></span>';
echo '<span class="icon-bar"></span>';
echo '<span class="icon-bar"></span>';
echo '</button>';
echo '<a class="navbar-brand" href="index.php">Platform</a>';
echo '</div>';
echo '<div id="navbar" class="navbar-collapse collapse">';
echo '<ul class="nav navbar-nav">';

if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    echo '<li><a href="profile.php">Profile</a></li>';
    echo '</ul>';
    echo '<div id="profile">' .
        '<form style="padding-left: 0;" class="navbar-form navbar-right" method="post" action="logout.php">' .
        '<input type="submit" name="logout" class="btn btn-danger" value="Sign out">' .
        '</form>' .
        '<h4 style="margin-right: 10px;" class="navbar-text navbar-right">Welcome: ' . $_SESSION['username'] . '</h4>' .
        '</div>';
} else {
    echo '</ul>';
    echo '<div id="profile-login" class="form-group">' .
        '<form class="navbar-form navbar-right" method="post" action="login.php">' .
        '<input type="text" placeholder="Email" name="email" class="form-control">' .
        '<input type="password" placeholder="Password" name="password" class="form-control">' .
        '<input type="submit" name="submit" class="btn btn-success" value="Sign in">' .
        '<input type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal" value="Register">' .
        '</form>' .
        '<p style="color:red" class="navbar-text navbar-right">';
    if (isset($_SESSION['loginError'])) {
        echo $_SESSION['loginError'];
    };
    echo '</p>' .
        '</div>';
}

echo '</div><!--/.navbar-collapse --> </div> </nav>';

?>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">Register as user</h4>
            </div>
            <div class="modal-body">
                <form id="registerForm" action="register.php" method="POST">
                    <div class="form-group">
                        <label for="newemail" class="control-label">Email:</label>
                        <input type="text" placeholder="Email" name="newemail" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="newpassword" class="control-label">Password:</label>
                        <input type="password" placeholder="Password" name="newpassword" class="form-control">
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" name="register" class="btn btn-success" value="Register">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
