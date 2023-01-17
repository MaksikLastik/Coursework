<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/result_helper.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/models/user_model.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/database.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/validator.php');


    if (!check_rights(Status::admin)) {
        die();
    };

    $link = new Database();
    $link = $link->connect();

    // Отбираем всех учителей
    $query = "SELECT * FROM `teachers`";
    $result = mysqli_query($link, $query);
    $teachers = [];

    while($row = mysqli_fetch_assoc($result)) {
        $teacher = [
            "id" => $row['id'],
            "name" => $row['teacher_name'],
            "email" => $row['email']
        ];
        // Поочередно добавляем их в единый массив, который вернем
        array_push($teachers, $teacher);
    }

    mysqli_close($link);

    return_ok($teachers, 200);

?>