<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/result_helper.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/models/user_model.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/database.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/validator.php');


    if (!check_rights(Status::admin)) {
        die();
    };

    check_get_field('email', 'string');
    check_get_field('password', 'string');
    check_get_field('name', 'string');

    $name = $_GET['name'];
    $pass = $_GET['password'];
    $email = $_GET['email'];

    $link = new Database();
    $link = $link->connect();

    $pass .= "1234567890";
    $pass = md5($pass);
    
    // Вставляем нового студента в базу данных 
    $query = "INSERT INTO `teachers` (`teacher_name`, `password`, `email`) VALUES ('$name', '$pass', '$email')";
    $result = mysqli_query($link, $query);

    $id = mysqli_insert_id($link);
    mysqli_close($link);

    if ($result) {
        $user = [
            "id" => $id,
            "name" => $name,
            "email" => $email,
            "role" => Status::teacher
        ];

        return_ok($user, 200);
    } else {
        return_error("Учитель не добавлен", 400);
    }

?>
