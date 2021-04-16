<?php
require "db.php"; // подключаем файл для соединения с БД
require __DIR__ . '/header.php';
?>
<body>
<?php if(isset($_SESSION['logged_user'])) : ;
//    $users = R::findAll('users');
?>
<div class="container-fluid">
    <div class="tool-bar">
        <div class="select-all">
            <label for="checkbox">Select All</label></><input type="checkbox"  id="select-all" class="form-check-input" type="checkbox"/>
        </div>
        <div class="tool-btns">
            <button type="button" id="block" class="btn btn-light">Block</button>
            <button type="button" id="delete" class="btn btn-default btn-lg btn-sm">
                <span class=" glyphicon glyphicon-unlock " aria-hidden="true"></span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                </svg>
            </button>
            <button type="button" id="unlock" class="btn btn-default btn-sm btn-lg">
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-unlock-fill" viewBox="0 0 16 16">
                    <path d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2z"/>
                </svg>
            </button>
        </div>
    </div>
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">Select User</th>
            <th scope="col">Id</th>
            <th scope="col">Login</th>
            <th scope="col">Email</th>
            <th scope="col">Date registration</th>
            <th scope="col">Last login</th>
            <th scope="col">Status</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT * FROM users ";
        $result = mysqli_query($conn,$sql);
        $user = mysqli_fetch_assoc($result);
        while($user = mysqli_fetch_assoc($result)): ?>
            <tr class="row-table">
                <td scope="row">

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="user" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                        </label>
                    </div>
                </td>
                <td class="user_id"><?php echo $user["id"]?></td>
                <td><?php echo $user['login']?></td>
                <td><?php echo $user['email']?></td>
                <td><?php echo $user['reg_date']?></td>
                <td><?php echo $user['last_login']?></td>
                <td><?php echo $user['status'] ?></td>
            </tr>
        <?php
        endwhile;
        ?>
        </tbody>
    </table>
    <a class="btn btn-primary log logout" href="logout.php">Выйти</a>
</div>

<?php else : ?>
<div class="container">
    <div class="row reg-log">
        <a class="btn btn-primary log" href="login.php">Авторизоваться</a><br>
        <a class="btn btn-primary reg" href="signup.php">Регистрация</a>
    </div>
</div>
<?php endif; ?>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script language="JavaScript">
</script>
<script>


    document.querySelector('#block').onclick = function() {
        let rows = document.querySelectorAll(".row-table");
        rows.forEach(function(row) {
            if(row.querySelector(".form-check-input").checked) {
                let $userID = row.querySelector(".user_id").innerHTML;
                let $block = "block";
                $.ajax({
                    url: "index.php",
                    type: "POST",
                    data: {userID:$userID, block:$block}
                });

                <?php
                if(isset($_POST['userID']) && isset($_POST['block'])) {
                    $uid = $_POST['userID'];
                    $sql = "UPDATE users SET status = 'blocked'  WHERE id='$uid'";
                    $result = mysqli_query($conn,$sql);
                    if ($uid == $_SESSION['logged_user']->id) {
                        unset($_SESSION['logged_user']);
                        exit("<meta http-equiv='refresh' content='0; url= /index.php'>");
                    }
                }
                ?>
            }
        });
        setInterval('location.reload()', 300);
    };

    document.getElementById('delete').onclick = function() {
        let rows = document.querySelectorAll(".row-table");
        rows.forEach(function(row) {
            if(row.querySelector(".form-check-input").checked) {
                let $userID = row.querySelector(".user_id").innerHTML;
                let $delUs = "delete";
                $.ajax({
                    url: "index.php",
                    type: "POST",
                    data: {userID:$userID,delUs:$delUs}
                });
                <?php
                if(isset($_POST['userID']) && isset($_POST['delUs'])) {
                    $uid = $_POST['userID'];
                    $sql = "DELETE FROM users WHERE id='$uid'";
                    $result = mysqli_query($conn,$sql);
                    if ($uid == $_SESSION['logged_user']->id) {
                        unset($_SESSION['logged_user']);
                        exit("<meta http-equiv='refresh' content='0; url= /index.php'>");
                    }
                }?>
            }
        });
        setInterval('location.reload()', 300);
    };
    document.getElementById('unlock').onclick = function() {
        let rows = document.querySelectorAll(".row-table");
        rows.forEach(function(row) {
            if(row.querySelector(".form-check-input").checked) {
                let $userID = row.querySelector(".user_id").innerHTML;
                let $unlock = "unlock";
                $.ajax({
                    url: "index.php",
                    type: "POST",
                    data: {userID:$userID,unlock:$unlock}
                });
                <?php
                if(isset($_POST['userID']) && isset($_POST['unlock'])) {
                    $uid = $_POST['userID'];
                    $sql = "UPDATE users SET status = 'offline'  WHERE id='$uid'";
                    $result = mysqli_query($conn,$sql);
                    if ($uid == $_SESSION['logged_user']->id) {
                        $sql = "UPDATE users SET status = 'online'  WHERE id='$uid'";
                        $result = mysqli_query($conn,$sql);
                    }
                }?>
            }
        });
        setInterval('location.reload()', 300);
    };

    let tr = document.querySelectorAll(".row-table"),
        i = tr.length;

    while (i--) {
        tr[i].onclick = clickTr;
    }

    function clickTr(event) {
        let inputs = this.getElementsByTagName('input');
        for (let x = 0; x < inputs.length; x++) {
            if (inputs[x] !== event.target && inputs[x].type == 'checkbox') {
                inputs[x].checked = !(inputs[x].checked);
            }
        }
    }
    document.getElementById('select-all').onclick = function() {
        let checkboxes = document.getElementsByName('user');
        for (let checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    }

</script>

