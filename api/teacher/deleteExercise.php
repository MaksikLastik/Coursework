<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/models/exercise_model.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/result_helper.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/database.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/validator.php');


    if (!check_rights(Status::teacher)) {
        die();
    };

    check_get_field('exercise_id', 'int');

    $exercise_id = $_GET['exercise_id'];
    $teacher_id = unserialize($_SESSION['user'])->id;

    $link = new Database();
    $link = $link->connect();

    $query = "SELECT * FROM exercises WHERE exercise_id = '$exercise_id' AND teacher_id = '$teacher_id'";
    $result = check_query(mysqli_query($link, $query), "Ошибка при подключении к базе данных", 500);
    check_query(mysqli_num_rows($result), "Задание не принадлежит учителю или задание не существует", 400);

    $query = "DELETE FROM exercises WHERE exercise_id = '$exercise_id'";
    check_query(mysqli_query($link, $query), "Ошибка базы данных при удалении задания", 500);
    check_query(mysqli_affected_rows($link), "Задание не существует", 400);

    $query = "DELETE FROM tasks_grades WHERE exercise_id = '$exercise_id'";
    check_query(mysqli_query($link, $query), "Ошибка базы данных при удалении оценок", 500);

    mysqli_close($link);

    return_ok("Задание удалено", 200);

?>