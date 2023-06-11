<?php
    namespace connect;
    //global $connection;
    $connection = mysqli_connect('localhost', 'root', '', 'onlydigital_case_db');
    //$connection = new mysqli('localhost', 'root', '', 'onlydigital_case_db');

    //print_r($connection);
    //$test = 'test';

    ///*
    if (!$connection) {
        die("connection failed: " . $connection->connect_error);
    }
    //*/

    function db_request($column, $param, $cond, $connection) {
        $column = mysqli_real_escape_string($connection, $column);
        $param = mysqli_real_escape_string($connection, $param);
        $cond = mysqli_real_escape_string($connection, $cond);

        $sql = "SELECT '$column' FROM users WHERE $column = '$param' AND $cond";
        //$res = $connection->query($sql);

        //print_r("<br> connection = $column, $param");
        //print_r($res);

        return($connection -> query($sql));
    }

    /*
    $param = 'test@mail.com';
    $column = 'email';
    print_r("<br> param: ");
    print_r(db_request($column, $param, $connection));
    */

    /*
    $sql = "SELECT * FROM users";
    $result = $connection->query($sql);


    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "id: " . $row["id"]. "; Name: " . $row["name"]. "; Phone number: " . $row["number"]. "<br>";
        }
    } else {
        echo "0 results";
    }
    $connection->close();
    */