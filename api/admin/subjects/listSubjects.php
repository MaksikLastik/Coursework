<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/result_helper.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/models/user_model.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/models/subject_model.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/database.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/validator.php');


    if (!check_rights(Status::admin)) {
        die();
    };

    $link = new Database();
    $link = $link->connect();

    // Отбираем все предмет
    $query = "SELECT name, teacher_name, grade_name, subject_id FROM subjects LEFT JOIN teachers ON subjects.teacher_id = teachers.id";
    $result = mysqli_query($link, $query);
    $subjects = [];

    while($row = mysqli_fetch_assoc($result)) {
        $subject = [
            "id" => $row['subject_id'],
            "name" => $row['name'],
            "grade" => $row['grade_name'],
            "teacher" => $row['teacher_name']
        ];
        // Поочередно добавляем их в единый массив, который вернем
        array_push($subjects, $subject);
    }

    mysqli_close($link);
    
    return_ok($subjects, 200);

?>