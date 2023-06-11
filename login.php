<?php
    session_start();

    use function connect\db_request;
    //require_once 'connection.php';
    require 'connection.php';
    //use connect as connect;
    global $connection;

    $login = $_POST['login'];
    $password = md5($_POST['password']);
    //$password2 = $_POST['password2'];
    //$email = $_POST['email'];
    //$number = $_POST['number'];
    //$connection;
    //$test;

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
        $pass_check = $connection -> query("SELECT * FROM users WHERE $login_check = '$login' AND 'pass' = '$password'");
        $column = 'pass';
        //$sql = "SELECT 'pass' FROM users WHERE pass = '$password'"; // ok!!!
        //$sql = "SELECT * FROM users WHERE $login_check = '$login'"; // ok!!!
        $sql = "SELECT * FROM users WHERE $login_check = '$login' AND pass = '$password'";
        $pass_check = $connection -> query($sql);

        print_r("<br>");
        //print_r("_SESSION['user'] before = $_SESSION['user']");
        /*
        print_r("<br>");
        print_r("login_check = $login_check; login = $login");
        print_r("<br> pass_check fetch_assoc");
        print_r($pass_check -> fetch_assoc());
        print_r("<br> pass_check");
        print_r($pass_check);
        //$_SESSION['message'] = $pass_check -> fetch_assoc();
        */

       //$login_check = login_check($login, $connection);
       if ($login_check === "false") {
           return false;
       }
       /*
       $pass_check = $connection -> query("SELECT * FROM users WHERE $login_check='$login' and 'pass'='$password'");
       print_r("<br>");
       print_r($pass_check);
       */
       if ($pass_check -> num_rows > 0) {
           $user_info = $pass_check -> fetch_assoc();
           $_SESSION['user'] = [
               'id' => $user_info['id'],
               'name' => $user_info['name'],
               'number' => $user_info['number'],
               'email' => $user_info['email'],
               'pass' => $user_info['pass'],
           ];

           //dd($_SESSION['user']);
           return true;
       } else {
           return false;
       }
    }

    ///*
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
    //*/

    //pass_check($login, $password, $connection);


    //print_r("name1 =  . $name");
    print_r('<br>');
    //print_r("name2 = " . $name2);
    echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';
