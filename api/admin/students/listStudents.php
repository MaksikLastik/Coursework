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
    $query = "SELECT * FROM `students`";
    $result = mysqli_query($link, $query);
    $students = [];

    while($row = mysqli_fetch_assoc($result)) {
        $student = [
            "id" => $row['student_id'],
            "name" => $row['student_name'],
            "email" => $row['email'],
            "grade" => $row['grade_name']
        ];
        // Поочередно добавляем их в единый массив, который вернем
        array_push($students, $student);
    }
    mysqli_close($link);

    return_ok($students, 200);

?>