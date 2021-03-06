<?php

use RedBeanPHP\RedException\SQL;

require "db.php";
require __DIR__ . '/header.php';
$data = $_POST;

if(isset($data['do_signup'])) {
    $errors = array();
    if(trim($data['login']) == '') {
        $errors[] = "Enter login!";
    }
    if(trim($data['email']) == '') {
        $errors[] = "Enter Email!";
    }
    if($data['password'] == '') {
        $errors[] = "Enter password!";
    }
    if($data['password_2'] != $data['password']) {
        $errors[] = "The repeated password was entered incorrectly!";
    }
    if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $data['email'])) {
        $errors[] = 'E-mail entered incorrectly!';
    }
    if(R::count('users', "login = ?", array($data['login'])) > 0) {
        $errors[] = "A user with this login exists!";
    }
    if(R::count('users', "email = ?", array($data['email'])) > 0) {
        $errors[] = "A user with this Email exists!";
    }
    if(empty($errors)) {
//        R::debug(true);
        $user = R::dispense('users');
        $login = $data['login'];
        $email = $data['email'];
        $reg_date = date('d.m.Y H:i');
        $last_login = date('d.m.Y H:i');
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (login, email, reg_date, last_login, password) VALUES ('$login', '$email', '$reg_date','$last_login','$password')";
        if(mysqli_query($conn, $sql)){
            echo "Records inserted successfully.";
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }
//        $user["login"] = $data['login'];
//        $user["email"] = $data['email'];
//        $user["reg_date"] = date('d.m.Y H:i');
//        $user["last_login"] = date('d.m.Y H:i');
//        $user["password"] = password_hash($data['password'], PASSWORD_DEFAULT);
//        dmp( $user );
//        try {
//            $id = R::store($user);
//            echo $id;
//        } catch (SQL $e) {
//            echo $e;
//        }
//        $conn->close();
        echo '<div class="alert alert-success" role="alert">You are registered successfully! <a href="login.php">log in</a>.</div><hr>';
    } else {
        echo '<div class="alert alert-danger" role="alert">' . array_shift($errors). '</div><hr>';
    }
}
?>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-6 ">
                <h2>Registration form</h2>
                <form action="signup.php" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="login" id="login" placeholder="Enter login">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
                        <input type="password" class="form-control" name="password_2" id="password_2" placeholder="Repeat password">
                        <button class="btn btn-primary" name="do_signup" type="submit">Register</button>
                    </div>
                </form>
                <br>
                <p>If you are not registered yet, then click <a href="login.php">there</a>.</p>
                <p>Go back to <a href="index.php">the main page </a>.</p>
            </div>
        </div>
    </div>
<?php require __DIR__ . '/footer.php'; ?>
