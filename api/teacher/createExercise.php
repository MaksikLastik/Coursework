<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/models/exercise_model.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/result_helper.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/database.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/validator.php');

    
    if (!check_rights(Status::teacher)) {
        die();
    };

    check_get_field('name', 'string');
    check_get_field('subject_id', 'int');
    check_get_field('text', 'string');

    $name = $_GET['name'];
    $subject_id = $_GET['subject_id'];
    $text = $_GET['text'];
    $teacher_id = unserialize($_SESSION['user'])->id;

    $link = new Database();
    $link = $link->connect();

    $query = "SELECT * FROM subjects WHERE subject_id = '$subject_id' AND teacher_id = '$teacher_id'";
    $result = check_query(mysqli_query($link, $query), 'Ошибка при подключении к базе данных', 500);

    $row = mysqli_fetch_assoc($result);
    $grade = $row['grade_name'];

    check_query(mysqli_num_rows($result), 'Нет такого предмета у учителя', 400);

    $query = "INSERT INTO exercises (text, subject_id, teacher_id, name) VALUES ('$text', $subject_id, $teacher_id, '$name')";
    $result = check_query(mysqli_query($link, $query), 'Ошибка при подключении к базе данных', 500);

    $res = [
        'id' => mysqli_insert_id($link),
        'text' => $text,
        'name' => $name,
        'grade' => $grade
    ];
    mysqli_close($link);

    if ($result) {
        return_ok($res, 200);
    } else {
        return_error("Задание не добавлено", 400);
    }

?>