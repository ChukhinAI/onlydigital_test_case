<?php
    session_start();

    require 'connection.php';
    use function connect\db_request;

    global $connection;

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
    if (empty($_POST['new_password']) or !isset($_POST['new_password'])) {
        $new_password = $password;
    } else {
        $new_password = $_POST['new_password'];
    }
    if (empty($_POST["email"])) {
        $email = $_SESSION['user']['email'];
    } else {
        $email = $_POST['email'];
    }
    if (empty($_POST["number"])) {
        $number = $_SESSION['user']['number'];
    } else {
        $number = $_POST['number'];
    }

    function uniqueness_check($name, $email, $number, $id, $connection)
    {
        $result = db_request('name', $name,'1', $connection);
        if ($result->num_rows > 0) {
            $_SESSION['user']['message'] = 'Пользователь с таким именем уже существует, попробуйте изменить имя.';
            header('Location: user_page.php');
        } else {
            $result = db_request('email', $email, 'id' != $id, $connection);
            if ($result->num_rows > 0) {
                $_SESSION['user']['message'] = "Пользователь с таким почтовым адресом: уже существует, попробуйте изменить его.";
                header('Location: user_page.php');
            } else {
                $result = db_request('email', $email, 'number'." = $number", $connection);
                if ($result->num_rows > 0) {
                    $_SESSION['user']['message'] = 'Пользователь с таким номером телефона уже существует, попробуйте изменить его.';
                    header('Location: user_page.php');
                }
            }
        }
    }

    $password = md5($password);
    $_SESSION['alert'] = $new_password;
    $new_password = md5($new_password);
    $old_email = $_SESSION['user']['email'];

    if ($connection->query("SELECT id FROM users WHERE email='$old_email' AND pass = '$password'")->num_rows > 0) {
        uniqueness_check($name, $email, $number, $id, $connection);
        mysqli_query($connection, "UPDATE users SET name='$name', email='$email', number='$number', pass='$new_password' WHERE id='$id'");

        $_SESSION['user'] = [
            'id' => $id,
            'name' => $name,
            'number' => $number,
            'email' => $email,
            //'pas' => $pas,
            'message' => "Вы зарегистрированы как $name. Используйте почту или номер телефона для входа.",
        ];
    } else {
        $_SESSION['user']['message'] = 'Пароль не верен, проверьте введенные данные.';
    }
    header('Location: user_page.php');
