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
    //if (empty($_POST["password"])) {
    //    $password = $_SESSION['user']['password'];
    //} else {
        $password = $_POST['password'];
    //}
    //if (empty($_POST["password2"])) {
    //    $password2 = $_SESSION['user']['password2'];
    //} else {
        $password2 = $_POST['password2'];
    //}
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
            $_SESSION['user']['message'] = 'Пользователь с таким именем уже существует, попробуйте изменить имя.';
            header('Location: user_page.php');
        } else {
            $sql = "SELECT email FROM users WHERE email='$email'";
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

        //$_SESSION['user']['message'] = "Вы зарегистрированы как $name. Используйте почту или номер телефона для входа.";
        $_SESSION['user'] = [
            'id' => $id,
            'name' => $name,
            'number' => $number,
            'email' => $email,
            'pas' => $pas,
            'message' => "Вы зарегистрированы как $name. Используйте почту или номер телефона для входа.",
        ];

        header('Location: user_page.php');

    } else {
        $_SESSION['user']['message'] = 'Пароли не совпадают, проверьте введенные данные.';
        //header('Location: user_page.php');
    }
