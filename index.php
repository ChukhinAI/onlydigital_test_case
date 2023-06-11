<?php
    session_start();
    if ((!empty($_SESSION['user']['id']))) { // проверка на то, что юзер вошел в учетку
        $_SESSION['user']['message'] = 'redirected to user_page';
        header('Location: user_page.php');
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
</head>
<body>
    <form method="post" action="login.php">
        <div class="mb-3">
            <label for="login" class="form-label">Email или номер телефона</label>
            <input type="text" class="form-control" id="login" name="login" required>
            <small>Номер в формате: 9091234578</small>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Войти</button>
        <a href="registration_form.php">Зарегистрироваться</a>
        <div class="message">
            <?php
                if (empty($_SESSION['user']['message'])) {
                    echo $_SESSION['user']['message'];
                    unset($_SESSION['user']['message']);
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