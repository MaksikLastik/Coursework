<?php

    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/result_helper.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/models/user_model.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/database.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/helpers/validator.php');

    
    if (!check_rights(Status::teacher)) {
        die();
    };

    check_get_field('student_id', 'int');
    check_get_field('exercise_id', 'int');
    check_get_field('task_grade', 'int');

    $student_id = $_GET['student_id'];
    $exercise_id = $_GET['exercise_id'];
    $task_grade = $_GET['task_grade'];

    $link = new Database();
    $link = $link->connect();

    // check if student and exercise belongs to teacher
    $teacher_id = unserialize($_SESSION['user'])->id;
    $query = "SELECT * FROM students WHERE student_id = $student_id AND grade_name IN (SELECT grade_name FROM subjects
        WHERE teacher_id = $teacher_id)";
    $result = check_query(mysqli_query($link, $query), "Ошибка при подключении к базе данных", 500);
    check_query(mysqli_num_rows($result), "Нет такого ученика у учителя", 400);

    $query = "UPDATE tasks_grades SET task_grade = $task_grade WHERE exercise_id = $exercise_id AND student_id = $student_id";
    $result = check_query(mysqli_query($link, $query), "Ошибка базы данных при обновлении оценки", 500);

    if (mysqli_affected_rows($link) == 0) {
        $query = "INSERT INTO tasks_grades (exercise_id, student_id, task_grade) SELECT $exercise_id, $student_id, $task_grade FROM dual
            WHERE EXISTS (SELECT * FROM students WHERE student_id = $student_id)
            AND EXISTS (SELECT * FROM exercises WHERE exercise_id = $exercise_id)";
        $result = check_query(mysqli_query($link, $query), "ОШибка базы данных при вставке оценки", 500);
    }

    mysqli_close($link);

    if ($result) {
        return_ok("Таблица оценок изменена", 200);
    } else {
        return_error("Таблица оценок не изменена", 400);
    }

?>