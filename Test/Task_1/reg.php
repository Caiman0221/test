<?php

$name = $_POST['name'];
$login = $_POST['login'];
$password = $_POST['password'];

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


$query = "CREATE TABLE IF NOT EXISTS `task1` (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(256) UNIQUE,
    password VARCHAR(256),
    name VARCHAR(256)
);";
mysqliQuery($query);

$query = "SELECT * FROM task1 WHERE login = '$login';";
$result = mysqliQuery($query);

if (mysqli_num_rows($result) > 0) {
    $answer->result = 'false';
    $answer->text = 'Пользователь с таким логином уже есть';
    echo(json_encode($answer));
    return;
}

$password_sha = sha1($password);

$query = "INSERT INTO `task1` VALUES (
    null,
    '$login',
    '$password_sha',
    '$name'
);";
mysqliQuery($query);

$answer->result = 'true';
$answer->name = $name;
$answer->login = $login;
$answer->password = $password_sha;
$answer->text = "Привет, $name";

echo(json_encode($answer));

?>
