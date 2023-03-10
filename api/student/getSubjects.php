<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/validator.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/database.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/models/user_model.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/models/subject_model.php');
    include_once $_SERVER['DOCUMENT_ROOT'].'/helpers/result_helper.php';


    if (!check_rights(Status::student)) {
        die();
    };

    $grade = unserialize($_SESSION['user'])->grade;

    $link = new Database();
    $link = $link->connect();
    // Отбираем все предметы для ученика этого класса
    $query = "SELECT * FROM subjects LEFT JOIN teachers ON subjects.teacher_id = teachers.id WHERE grade_name = '$grade'";
    $result = mysqli_query($link, $query);
    $subjects = array();
    while($row = mysqli_fetch_assoc($result)) {
        $subject = new Subject($row['name'], $row['teacher_name'], $row['grade_name']);
        $subject->id = $row['subject_id'];
        $subjects[] = $subject;
    }

    mysqli_close($link);

    return_ok($subjects, 200);

?>