<?php
    session_start();

    use function connect\db_request;
    require 'connection.php';
    global $connection;

    $login = $_POST['login'];
    $password = md5($_POST['password']);


    function login_check($login, $connection): string {
        if (db_request('email', $login,'1', $connection) -> num_rows > 0) {
            return "email";
        } elseif (db_request('number', $login,'1', $connection) -> num_rows > 0) {
            return "number";
        }
        else {
            return "false";
        }
    }

    function pass_check($login, $password, $connection, $user_info): bool {
        $login_check = login_check($login, $connection);
        $sql = "SELECT * FROM users WHERE $login_check = '$login' AND pass = '$password'";
        $pass_check = $connection -> query($sql);

        if ($login_check === "false") {
            return false;
        }
        if ($pass_check -> num_rows > 0) {
            $user_info = $pass_check -> fetch_assoc();
            $_SESSION['user'] = [
                'id' => $user_info['id'],
                'name' => $user_info['name'],
                'number' => $user_info['number'],
                'email' => $user_info['email'],
                'pass' => $user_info['pass'],
            ];
            return true;
        } else {
            return false;
        }
    }

    $user_info = [];
    if (pass_check($login, $password, $connection, $user_info)) {
        header('Location: user_page.php');
        print_r('sucess');
    } else {
        $_SESSION['user']['message'] = 'Пара пароль-логин не найдена, проверьте введенные данные.';
        header('Location: index.php');
        print_r('<br>fail');
    }

    print_r("<br>");
    print_r("user_info after = $user_info");
    print_r('<br>');
    echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';
