<?php
    namespace connect;

    $connection = mysqli_connect('localhost', 'root', '', 'onlydigital_case_db');
    if (!$connection) {
        die("connection failed: " . $connection->connect_error);
    }

    function db_request($column, $param, $cond, $connection) {
        $column = mysqli_real_escape_string($connection, $column);
        $param = mysqli_real_escape_string($connection, $param);
        $cond = mysqli_real_escape_string($connection, $cond);

        $sql = "SELECT '$column' FROM users WHERE $column = '$param' AND $cond";

        return($connection -> query($sql));
    }
