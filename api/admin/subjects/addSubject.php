<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/result_helper.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/models/user_model.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/database.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/validator.php');


    if (!check_rights(Status::admin)) {
        die();
    };

    check_get_field('name', 'string');
    check_get_field('teacher', 'int');
    check_get_field('grade', 'string');

    $name = $_GET['name'];
    $teacher = $_GET['teacher'];
    $grade = $_GET['grade'];

    $link = new Database();
    $link = $link->connect();
    
    // Вставляем новый предмет в базу данных 
    $query = "INSERT INTO `subjects` (`name`, `grade_name`, `teacher_id`) VALUES ('$name', '$grade', '$teacher')";
    $result = mysqli_query($link, $query);

    $id = mysqli_insert_id($link);
    mysqli_close($link);

    if($result) {
        $subject = [
            "id" => $id,
            "name" => $name,
            "grade" => $grade,
            "teacher" => $teacher
        ];
        return_ok($subject, 200);
    } else {
        return_error("Предмет не добавлен", 400);
    }

?>