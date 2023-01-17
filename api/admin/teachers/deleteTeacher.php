<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/result_helper.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/models/user_model.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/database.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/validator.php');


    if (!check_rights(Status::admin)) {
        die();
    };

    check_get_field('id', 'int');

    $id = $_GET['id'];

    $link = new Database();
    $link = $link->connect();

    // Удаляем учителя из базу данных 
    $query = "DELETE FROM `teachers` WHERE `id` = $id";
    $result = mysqli_query($link, $query);
    mysqli_close($link);

    if ($result) {
        return_ok("Учитель удалён", 200);
    } else {
        return_error("Учитель не удалён", 400);
    }

?>