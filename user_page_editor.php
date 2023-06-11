<?php
    session_start();

    require 'connection.php';
    //require_once 'registration.php';
    use function connect\db_request;
    //use function registration\uniqueness_check;

    global $connection;

    ///*
    if (isset($_SESSION['user'])) { // проверка на то, что юзер вошел в учетку, работает без id
        $id = $_SESSION['user']['id'];
    } else {
        header('Location: index.php');
    }
        if (isset($_POST["name"])) {
        $name = $_POST['name'];
    } else {
        $name = $_SESSION['user']['name'];
    }
    if (isset($_POST["password"])) {
        $password = $_POST['password'];
    } else {
        $password = $_SESSION['user']['password'];
    }
    if (isset($_POST["password2"])) {
        $password2 = $_POST['password2'];
    } else {
        $password2 = $_SESSION['user']['password2'];
    }
    if (isset($_POST["new_password"])) {
        $new_password = $_POST['new_password'];
    } else {
        $new_password = $_SESSION['user']['password'];
    }
    if (isset($_POST["email"])) {
        $email = $_POST['email'];
    } else {
        $email = $_SESSION['user']['email'];
    }
    if (isset($_POST["number"])) {
        $number = $_POST['number'];
    } else {
        $name = $_SESSION['user']['number'];
    }

    //*/
    /*
    $id = $_SESSION['user']['id'];
    $name = $_SESSION['user']['name'];
    $password = $_SESSION['user']['password'];
    $password2 = $_SESSION['user']['password2'];
    $email = $_SESSION['user']['email'];
    $number = $_SESSION['user']['number'];
    */
    foreach ($_POST as $key => $value) {
        //echo $col;
        echo "<br>";
    }

    ///*
    function uniqueness_check($name, $email, $number, $connection)
    {
        //$sql = "SELECT name FROM users WHERE name='$name'";
        //$result = $connection->query($sql);
        $result = db_request('name', $name,'1', $connection);

        if ($result->num_rows > 0) {
            $sql = "SELECT email FROM users WHERE email='$email'";
            $result = $connection->query($sql);
            $_SESSION['message'] = 'Пользователь с таким именем уже существует, попробуйте изменить имя.';
            header('Location: user_page_editor.php');
        } else {
            $sql = "SELECT email FROM users WHERE email='$email'";
            $result = $connection->query($sql);
            if ($result->num_rows > 0) {
                $_SESSION['message'] = 'Пользователь с таким почтовым адресом уже существует, попробуйте изменить его.';
                header('Location: user_page_editor.php');
            } else {
                $sql = "SELECT email FROM users WHERE number='$number'";
                $result = $connection->query($sql);
                if ($result->num_rows > 0) {
                    $_SESSION['message'] = 'Пользователь с таким номером телефона уже существует, попробуйте изменить его.';
                    header('Location: user_page_editor.php');
                }
            }
        }
    }
    //*/

    if ($password2 === $password) {
        // проверка на уникальность логина, почты, телефона
        uniqueness_check($name, $email, $number, $connection);
        // тут дальше будет header с редиректом на форму для авторизованных с возможностью редактировать данные учетки

        //$pas = password_hash($password, PASSWORD_BCRYPT, ['cost' => 8]);
        //$pas = md5($password); $new_password
        $pas = md5($new_password);
        //print_r($pas);
        mysqli_query($connection, "UPDATE users SET name='$name', email='$email', number='$number', pass='$pas' WHERE id='$id'");

        $_SESSION['message'] = "Вы зарегистрированы как $name. Используйте почту или номер телефона для входа.";
        $_SESSION['user'] = [
            'name' => $name,
            'number' => $number,
            'email' => $email,
            'pas' => $pas,
        ];

        header('Location: user_page.php');

    } else {

        $_SESSION['message'] = 'Пароли не совпадают, проверьте введенные данные.';
        header('Location: user_page.php');
    }
