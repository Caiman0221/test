<?php

$login = $_POST['login'];
$password = $_POST['password'];
$sha = $_POST['sha'];

$answer = (object) array();

function mysqliConnect() {
    $mysqli = new mysqli('localhost','user','pass','db');
    return($mysqli);
}

function mysqliClose() {
    mysqliConnect()->close;
}

function mysqliQuery($query) {
    if ($result = mysqliConnect()->query($query)) {
        return($result);
        $result->close();
    } else {
        return(false);
    }
    mysqliClose();
}

$query = "SELECT * FROM `task1` WHERE `login` = '$login';";
$result = mysqliQuery($query);

if (mysqli_num_rows($result) > 0) {
    $result = mysqli_fetch_row($result);

    $id_db = $result[0];
    $login_db = $result[1];
    $password_db = $result[2];
    $name_db = $result[3];

    if ($sha == 'true') {
        $password_sha = $password;
    } else {
        $password_sha = sha1($password);
    }

    if ($password_db == $password_sha) {
        $answer->result = "true";
        $answer->login = $login_db;
        $answer->password = $password_db;
        $answer->name = $name_db;
        $answer->text = "Привет, $name_db";
        $answer->sha = $sha;
    } else {
        $answer->result = "false";
        $answer->text = "Неправильный логин или пароль";
    }
} else {
    $answer->result = 'false';
    $answer->text = "Неправильный логин или пароль";
}

echo(json_encode($answer));

?>
