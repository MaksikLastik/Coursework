<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/result_helper.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/models/user_model.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/models/exercise_model.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/database.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/validator.php');


    if (!check_rights(Status::teacher)) {
        die();
    };

    check_get_field('subject_id', 'int');

    $subject_id = $_GET['subject_id'];
    $teacher_id = unserialize($_SESSION['user'])->id;

    $link = new Database();
    $link = $link->connect();

    $query = "SELECT * FROM subjects WHERE subject_id = '$subject_id' AND teacher_id = '$teacher_id'";
    $result = check_query(mysqli_query($link, $query), 'Ошибка при подключении к базе данных', 500);
    check_query(mysqli_num_rows($result), 'Нет такого предмета у учителя', 400);

    $row = mysqli_fetch_assoc($result);
    $grade = $row['grade_name'];

    $query = "SELECT * FROM exercises WHERE subject_id = '$subject_id'";
    $result = check_query(mysqli_query($link, $query), 'Ошибка при подключении к базе данных', 500);

    $exercises = [];
    while($row = mysqli_fetch_assoc($result)) {
        $exercise = [
            "name" => $row['name'],
            "id" => $row['exercise_id'],
            "text" => $row['text'],
            "grade" => $grade
        ];
        array_push($exercises, $exercise);
    }

    mysqli_close($link);

    return_ok($exercises, 200);

?>