<?php
require "db.php";
require __DIR__ . '/header.php';
$data = $_POST;
if(isset($data['do_login'])) {
    $errors = array();
    $user = R::findOne('users', 'login = ?', array($data['login']));
    if($user) {
        if ($user->status == "blocked") {
            $errors[] = "Oops ... you're blocked ((";
        }else if(password_verify($data['password'], $user->password)) {
            $user->last_login = date('d.m.Y H:i');
            $user->status = "online";
            R::store($user);
            $_SESSION['logged_user'] = $user;
            exit("<meta http-equiv='refresh' content='0; url= /index.php'>");
        }  else {
            $errors[] = 'Password entered incorrectly!';
        }
    } else {
        $errors[] = 'User with this username was not found!';
    }
    if(!empty($errors)) {
        echo '<div style="color: red; ">' . array_shift($errors). '</div><hr>';
    }
}
?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <h3>Authorization form</h3>
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label class="form-label">Login</label>
                        <input type="text" class="form-control" name="login" id="login" placeholder="Enter login" required>
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="pass" placeholder="Enter password" required>
                    </div>
                    <button class="btn btn-primary" name="do_login" type="submit">Авторизоваться</button>
                </form>
                <br>
                <p>If you are not registered yet, then click <a href="signup.php">there</a>.</p>
                <p>Go back to <a href="index.php">the main page </a>.</p>
            </div>
        </div>
    </div>
<?php require __DIR__ . '/footer.php'; ?>