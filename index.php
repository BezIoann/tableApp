<?php
require "db.php"; // подключаем файл для соединения с БД
$title="Главная страница"; // название формы
require __DIR__ . '/header.php'; // подключаем шапку проекта
?>
<?php if(isset($_SESSION['logged_user'])) : ;?>
<?php
    $users = R::findAll('users');
?>
    <div class="tool-bar">
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
    <input type="checkbox"  id="select-all" class="form-check-input" type="checkbox"/>
    <table class="table">
    <thead>
    <tr>
        <th scope="col">Select User</th>
        <th scope="col">Id</th>
        <th scope="col">Login</th>
        <th scope="col">Email</th>
        <th scope="col">Date registration</th>
        <th scope="col">Last visit</th>
        <th scope="col">Status</th>
    </tr>
    </thead>
        <tbody>
        <?php
        foreach ($users as $user): ?>
        <tr class="row-table">
            <td>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="user" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Default checkbox
                    </label>
                </div>
            </td>
            <td class="user_id"><?php echo $user->id?></td>
            <td><?php echo $user->login?></td>
            <td><?php echo $user->email?></td>
            <td><?php echo $user->reg_date?></td>
            <td><?php echo $user->last_login?></td>
            <td><?php echo $user->status ?></td>
        </tr>
    <?php
            endforeach;
        ?>
        </tbody>
    </table>
<a href="logout.php">Выйти</a>
<?php else : ?>

    <a href="login.php">Авторизоваться</a><br>
    <a href="signup.php">Регистрация</a>

<?php endif; ?>
<?php require __DIR__ . '/footer.php'; ?> <!-- Подключаем подвал проекта -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script language="JavaScript">
    document.querySelector('#delete').onclick = function() {
        let rows = document.querySelectorAll(".row-table");
        rows.forEach(function(row) {
            if(row.querySelector(".form-check-input").checked) {
                let userID = row.querySelector(".user_id").innerHTML;
                console.log(userID);
                $.ajax({
                    url: "index.php",
                    type: "POST",
                    data: {userID:userID}
                });
                <?php
                $uid1 = 0;
                if(isset($_POST['userID'])) :
                    $uid = $_POST['userID'];
                    $us = R::load('ex4', $uid);
                    $uid1 = $uid;
                $deletegame = R::exec('DELETE  FROM `users` WHERE id = ? ',[$uid]);
                    R::trash($deletegame); //удаляем запись с id=2 из таблицы category
                    ?>
                    console.log("<?php echo $uid1; ?>");
                <?php endif; ?>
            }
        });

    };
    document.getElementById('select-all').onclick = function() {
        var checkboxes = document.getElementsByName('user');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    }
</script>
