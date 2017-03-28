<?php

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
echo '<a class="navbar-brand" href="index.php">Workling</a>';
echo '</div>';
echo '<div id="navbar" class="navbar-collapse collapse">';
echo '<ul class="nav navbar-nav">';

if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    echo '<li><a href="profile.php">Profile</a></li>';
    echo '</ul>';
    echo '<div id="profile">' .
        '<form style="padding-left: 0;" class="navbar-form navbar-right" method="post" action="logout.php">' .
        '<input type="submit" name="logout" class="btn btn-success" value="Sign out">' .
        '</form>' .
        '<h4 style="margin-right: 10px;" class="navbar-text navbar-right">Welcome: ';

    if (isset($_SESSION['navn'])) {
        echo $_SESSION['navn'];
    } else {
        echo $_SESSION['username'];
    }

    echo '</h4>' .
        '</div>';
} else {
    echo '<li><a href="forum.php">Jobopslag</a></li>';
    echo '</ul>';
    echo '<div id="profile-login" class="form-group">' .
        '<form class="navbar-form navbar-right" method="post" action="login.php">' .
        '<input type="button" style="margin-right: 12px;" class="btn btn-success" data-toggle="modal" data-target="#loginModal" value="Login">' .
        '<input type="button" class="btn btn-success" data-toggle="modal" data-target="#registerModal" value="Register">' .
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
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true"></span></button>
                <h4 class="modal-title" id="exampleModalLabel">Login as user</h4>
            </div>
            <div class="modal-body">
                <form id="loginForm" action="login.php" method="POST">
                    <div class="form-group">
                        <label for="email" class="control-label">Email:</label>
                        <input type="email" placeholder="Email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label">Password:</label>
                        <input type="password" placeholder="Password" name="password" class="form-control">
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" name="login" class="btn btn-success" value="Login">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true"></span></button>
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
