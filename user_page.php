<?php
    session_start();
    if (!isset($_SESSION['user'])) { // проверка на то, что юзер вошел в учетку
        header('Location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Страница пользователя</title>
</head>
<body>
<h1>Редактор профиля пользователя <?=  $_SESSION['user']['name'] ?></h1>
<form method="post" action="user_page_editor.php">
    <div class="mb-3">
        <label for="name" class="form-label">Имя пользователя</label>
        <input type="text" class="form-control" id="name" name="name" value="<?=  $_SESSION['user']['name'] ?>">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="mb-3">
        <label for="password2" class="form-label">Подтвердите пароль</label>
        <input type="password" class="form-control" id="password2" name="password2" >
    </div>
    <div class="mb-3">
        <label for="new_password" class="form-label">Изменить пароль</label>
        <input type="password" class="form-control" id="new_password" name="new_password">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?=  $_SESSION['user']['email'] ?>">
    </div>
    <div class="mb-3">
        <label for="number" class="form-label">Номер телефона</label>
        <input type="tel" class="form-control" id="number" name="number" pattern="[0-9]{10}"
               value="<?=  $_SESSION['user']['number'] ?>">
        <small>в формате: 9091234578</small>
    </div>
    <button type="submit" class="btn btn-primary">Подтвердить изменения</button>
    <a href="logout.php" class="btn btn-primary">Выход</a>
    <div class="message">
        <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
    </div>
</form>

<?php
echo '<pre>';
print_r($_SESSION);
echo '</pre>';
?>

</body>
</html>