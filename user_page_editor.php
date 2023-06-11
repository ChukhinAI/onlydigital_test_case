<?php
    session_start();

    require 'connection.php';
    //require_once 'registration.php';
    use function connect\db_request;
    //use function registration\uniqueness_check;

    global $connection;


echo '<pre>';
print_r($_SESSION);
print_r($_SESSION['user']['id']);
echo '</pre>';


///*
    if (!empty($_SESSION['user']['id'])) { // проверка на то, что юзер вошел в учетку, работает без id
        $id = $_SESSION['user']['id'];
    } else {
        header('Location: index.php');
    }
    if (empty($_POST["name"])) {
        $name = $_SESSION['user']['name'];
    } else {
        $name = $_POST['name'];
    }
    $password = $_POST['password'];
    if (empty($_POST["new_password"])) {
        $new_password = $password;
    } else {
        $new_password = $_POST['password'];
    }
    if (empty($_POST["email"])) {
        $email = $_SESSION['user']['email'];
    } else {
        $email = $_POST['email'];
    }
    if (empty($_POST["number"])) {
        $number = $_SESSION['user']['number'];
    } else {
        $name = $_POST['number'];
    }

    function uniqueness_check($name, $email, $number, $connection)
    {
        $result = db_request('name', $name,'1', $connection);
        $sql = "SELECT email FROM users WHERE email='$email'";
        if ($result->num_rows > 0) {
            $_SESSION['user']['message'] = 'Пользователь с таким именем уже существует, попробуйте изменить имя.';
            header('Location: user_page.php');
        } else {
            $result = $connection->query($sql);
            if ($result->num_rows > 0) {
                $_SESSION['user']['message'] = 'Пользователь с таким почтовым адресом уже существует, попробуйте изменить его.';
                header('Location: user_page.php');
            } else {
                $sql = "SELECT email FROM users WHERE number='$number'";
                $result = $connection->query($sql);
                if ($result->num_rows > 0) {
                    $_SESSION['user']['message'] = 'Пользователь с таким номером телефона уже существует, попробуйте изменить его.';
                    header('Location: user_page.php');
                }
            }
        }
    }

    if ($connection->query("SELECT id FROM users WHERE email='$email' AND pass = '$password'")->num_rows > 0) {
        // проверка на уникальность логина, почты, телефона
        uniqueness_check($name, $email, $number, $connection);
        $pas = md5($new_password);
        mysqli_query($connection, "UPDATE users SET name='$name', email='$email', number='$number', pass='$pas' WHERE id='$id'");

        $_SESSION['user'] = [
            'id' => $id,
            'name' => $name,
            'number' => $number,
            'email' => $email,
            'pas' => $pas,
            'message' => "Вы зарегистрированы как $name. Используйте почту или номер телефона для входа.",
        ];

    } else {
        $_SESSION['user']['message'] = 'Пароли не совпадают, проверьте введенные данные.';
    }
    header('Location: user_page.php');
