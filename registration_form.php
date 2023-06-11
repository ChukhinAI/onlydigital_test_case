<?php
    session_start();
    if (isset($_SESSION['user']['id'])) { // проверка на то, что юзер вошел в учетку
    header('Location: user_page.php');
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Форма регистрации</title>
</head>
<body>
<form method="post" action="registration.php">
    <div class="mb-3">
        <label for="name" class="form-label">Имя пользователя</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="mb-3">
        <label for="password2" class="form-label">Подтвердите пароль</label>
        <input type="password" class="form-control" id="password2" name="password2" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="number" class="form-label">Номер телефона</label>
        <input type="tel" class="form-control" id="number" name="number" pattern="[0-9]{10}"
               required>
        <small>в формате: 9091234578</small>
    </div>
    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
    <div class="message">
        <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
    </div>
</form>

</body>
</html>