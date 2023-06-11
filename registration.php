<?php
    namespace registration;
    session_start();
    use function connect\db_request;
    require 'connection.php';
    global $connection;

    $name = $_POST['name'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $email = $_POST['email'];
    $number = $_POST['number'];

    function uniqueness_check($name, $email, $number, $connection)
    {
        //$sql = "SELECT name FROM users WHERE name='$name'";
        //$result = $connection->query($sql);
        $result = db_request('name', $name, '', $connection);

        if ($result -> num_rows > 0) {
            $_SESSION['message'] = 'Пользователь с таким именем уже существует, попробуйте изменить имя.';
            header('Location: registration_form.php');
        } else {
            $sql = "SELECT email FROM users WHERE email='$email'";
            $result = $connection->query($sql);
            if ($result->num_rows > 0) {
                $_SESSION['message'] = 'Пользователь с таким почтовым адресом уже существует, попробуйте изменить его.';
                header('Location: registration_form.php');
            } else {
                $sql = "SELECT email FROM users WHERE number='$number'";
                $result = $connection->query($sql);
                if ($result->num_rows > 0) {
                    $_SESSION['message'] = 'Пользователь с таким номером телефона уже существует, попробуйте изменить его.';
                    header('Location: registration_form.php');
                }
            }
        }
    }

    if ($password2 === $password) {
        // проверка на уникальность логина, почты, телефона
        uniqueness_check($name, $email, $number, $connection);
        // тут дальше будет header с редиректом на форму для авторизованных с возможностью редактировать данные учетки

        //$pas = password_hash($password, PASSWORD_BCRYPT, ['cost' => 8]);
        $pas = md5($password);
        //print_r($pas);
        mysqli_query($connection, "INSERT INTO users (name, email, number, pass) VALUES ('$name', '$email', '$number', '$pas')");
        $sql = "SELECT id FROM users WHERE email = '$email' AND pass = '$password'";
        $pass_check = $connection -> query($sql);
        $_SESSION['user']['id'] = $pass_check;
        $_SESSION['message'] = "Вы зарегистрированы как $name. Используйте почту или номер телефона для входа.";
        header('Location: user_page.php');

    } else {

        $_SESSION['message'] = 'Пароли не совпадают, проверьте введенные данные.';
        header('Location: registration_form.php');
    }
