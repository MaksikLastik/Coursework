# Coursework
## Цель работы
Создать журнал успеваемости учащихся
## Задания
- Создать админский интерфейс для добавления учителей, предметов и учеников
- Создать интерфейс учителя для создания заданий и последующего оценивания учеников по ним
- Создать интерфейс ученика для просмотра своих заданий и оценок

## Структура базы данных
1. **admins**: ![alt-текст](https://github.com/MaksikLastik/Coursework/blob/main/image%20for%20README/База%20данных%20admins.png)
- id (Уникальный идентификатор админа): INT, AUTO_INCREMENT
- name (Email админа): VARCHAR(50)
- password (Пароль админа): VARCHAR(32)
2. **students**: ![alt-текст](https://github.com/MaksikLastik/Coursework/blob/main/image%20for%20README/База%20данных%20students.png)
- student_id (Уникальный идентификатор ученика): INT, AUTO_INCREMENT
- student_name (ФИО ученика): VARCHAR(50)
- email (Email ученика): VARCHAR(50)
- password (Пароль ученика): VARCHAR(32)
- grade_name (Класс ученика): VARCHAR(5)
3. **teachers**: ![alt-текст](https://github.com/MaksikLastik/Coursework/blob/main/image%20for%20README/База%20данных%20teachers.png)
- id (Уникальный идентификатор учителя): INT, AUTO_INCREMENT
- teacher_name (ФИО учителя): VARCHAR(50)
- password (Пароль учителя): VARCHAR(32)
- email (Email учителя): VARCHAR(50)
4. **subjects**: ![alt-текст](https://github.com/MaksikLastik/Coursework/blob/main/image%20for%20README/База%20данных%20subjects.png)
- subject_id (Уникальный идентификатор предмета): INT, AUTO_INCREMENT
- teacher_id (Уникальный идентификатор ученика, к торому привязан этот предмет): INT, `teacher_id` связан с `id` в таблице `teachers`
- name (Название предмета): VARCHAR(50)
- grade_name (Класс, в котором преподаётся этот предмет): VARCHAR(5)
5. **exercises**: ![alt-текст](https://github.com/MaksikLastik/Coursework/blob/main/image%20for%20README/База%20данных%20exercises.png)
- exercise_id (Уникальный идентификатор задания): INT, AUTO_INCREMENT
- name (Название задания): VARCHAR(50)
- text (Описание задания): TEXT
- subject_id (Уникальный идентификатор предмета, по которому даётся это задание): INT, `subject_id` связан с `subject_id` в таблице `subjects`
- teacher_id (Уникальный идентификатор учителя, который дал это задание): INT, `teacher_id` связан с `id` в таблице `teachers`
6. **tasks_grades**: ![alt-текст](https://github.com/MaksikLastik/Coursework/blob/main/image%20for%20README/База%20данных%20tasks_grades.png)
- id (Уникальный идентификатор оценки): INT, AUTO_INCREMENT
- exercise_id (Уникальный идентификатор задания, по которому выставляется оценка): INT, `exercise_id` связан с `exercise_id` в таблице `exercises`
- student_id (Уникальный идентификатор ученика, которого оценивают по заданию): INT, `student_id` связан с `student_id` в таблице `students`
- task_grade (Оценка): INT

## Пользовательский интерфейс
### Вход в систему
В поле Email вводится почта пользователя и пароль, а также выбирается статус на сервере (Учитель, ученик, администратор). 
#### ![alt-текст](https://github.com/MaksikLastik/Coursework/blob/main/image%20for%20README/Вход%20в%20дневничок.png)
При неправильном заполнении полей или при неправильном выборе статуса пользователя появится ошибка "Неверная почта или пароль или сервер не отвечает", иначе войдет в систему. 
#### ![alt-текст](https://github.com/MaksikLastik/Coursework/blob/main/image%20for%20README/Ошибка%20при%20входе%20в%20дневничок.png)

### Интерфейс ученика
В левой части экрана появляются предметов, которые преподаются в классе ученика с кнопкой "Открыть", кнопка "Выйти" и карта с раположением его школы (подключен сторонний api от Яндекс.Карт) 
#### ![alt-текст](https://github.com/MaksikLastik/Coursework/blob/main/image%20for%20README/Левая%20часть%20интерфейса%20ученика.png). Если нажать на кнопку "Выйти", то ученик выйдет из аккаунта.
Если нажать на кнопку "Открыть" любого из представленных предметов, преподаваемых ученика, то во второй части экрана появится таблица, состоящая из всех заданий, выданных ученику этго класса, их описаний и оценок. 
#### ![alt-текст](https://github.com/MaksikLastik/Coursework/blob/main/image%20for%20README/Правая%20часть%20интерфейса%20ученика.png).

### Интерфейс учителя
В левой части экрана появляются предметов, которые преподает учитель дял разных классов с кнопкой "Открыть", кнопка "Выйти" и карта с раположением его школы (подключен сторонний api от Яндекс.Карт) 
#### ![alt-текст](. Если нажать на кнопку "Выйти", то учитель выйдет из аккаунта. (фотка левой части интерфейса учителя).
Если нажать на кнопку "Открыть" любого из представленных предметов, преподаваемых учителем, то во второй части экрана отобразятся форма для добавления нового задания по выбранному предмету, и уже выложенные задания с кнопкой "Удалить" и "Открыть". Если нажать "Удалить", то задание удалится. (фотка центральной части интерфейса ученика) 
#### ![alt-текст](https://github.com/MaksikLastik/Coursework/blob/main/image%20for%20README/Правая%20часть%20интерфейса%20учителя.png).
Если нажать на кнопку "Открыть" любого из представленных заданий, то в третьей части экрана появится таблица с учениками и их оценками, которые можно редактировать.
#### ![alt-текст](https://github.com/MaksikLastik/Coursework/blob/main/image%20for%20README/Центральная%20часть%20интерфейса%20учителя.png).
 
### Интерфейс администратора
Сверху вних расположены таблицы учителей, учеников и предметов, в которых можно удалять поля с помощью кнопки "Удалить", находящейся на той же строке, и в конце - кнопка "Выйти". Если ее нажать, то админ выйдет с аккаунта. 
После каждой таблицы есть кнопки "Добавить нового учителя", "Добавить нового ученика" и "Добавить новый предмет" соответсвенно. Эти кнопки разворачивают форму для добавления новых полей, где можно заполнить поля и, нажав на копку "Добавить", добавить ученика, учителя или предмет. 
#### ![alt-текст](https://github.com/MaksikLastik/Coursework/blob/main/image%20for%20README/Админский%20интерфейс%20с%20учителями%20и%20формой.png)

## Алгоритмы и их реализация
### Алгоритм входа в систему
Данные с формы отправляются на сервер через метод fetch (login.js). На сервере производится проверка полей, заполненных в форме, с данными одной из таблицы `teachers`, `students`, `admins` (login.php). При успешном ответе от сервера производится переход на страницу пользователя, иначе возвращается ошибку.
1. login.php
```php
$email = $_GET['email'];
$pass = $_GET['password'];

switch ($_GET['role']) {
    case "admin_login":
        $user = new Admin($email, $pass);
        $res = $user->login();
        break;

    case "teacher_login":
        $user = new Teacher($email, $pass);
        $res = $user->login();
        break;

    case 'student_login':
        $user = new Student($email, $pass);
        $res = $user->login();
        break;

    default:
        return_error("Неправильная роль", 400);
        break;
}

if ($res) {
    $_SESSION['user'] = serialize($user);
    return_ok('Авторизован', 200);
} else {
    return_error("Неверный пароль", 401);
}
```
2. login.js
```js
fetch(`${BASE_API_URL}auth/login.php?${params}`)
    .then(response => {
        if (response.ok) {
            return response.json();
        }
        throw new Error('Request failed.');
    })
    .then(data => {
        if (data.ok) {
            if (role === 'student_login') {
                document.location.href = '../frontend/student/student.html';
            } else if (role === 'teacher_login') {
                document.location.href = '../frontend/teacher/teacher.html';
            } else if (role === 'admin_login') {
                document.location.href = '../frontend/admin/admin.html';
            }
        }
    })
    .catch(error => {
        errorBox.textContent = 'Неверная почта или пароль или сервер не отвечает';
        errorBox.style.display = 'block';
        console.log(error);
    });
```

### Алгоритм добавления и удаления предметов, учителей и учеников
Части кода будут приведены только по ученику, т.к. с учителем и администратором алгоритмы добавления и удаления схожы. Данные с формы отправляются на сервер через метод fetch (student.js). На сервере производится добавление данных в одну из таблиц `teachers`, `students`, `subjects` (в зависимости от заполняемой формы)(addStudent.php). При успешном ответе от сервера в базе данных появится новое поле, иначе возвращается ошибку.
1. admin.js
```js
fetch(BASE_API_URL + 'admin/students/addStudent.php?' + params)
    .then(response => response.json())
    .then(data => {
        if (!data.ok) {
            console.log(data);
            return;
        }
        const student = {
            id: data.result.id,
            email: data.result.email,
            name: data.result.name,
            grade: data.result.grade
        };
        createStudentRow([student]);
    })
    .catch(error => {
        console.log(error);
    });
});
```
2.
```php
$link = new Database();
$link = $link->connect();

$pass .= "1234567890";
$pass = md5($pass);

$query = "INSERT INTO `students` (`grade_name`, `student_name`, `password`, `email`) VALUES ('$grade', '$name', '$pass', '$email')";
$result = mysqli_query($link, $query);

$id = mysqli_insert_id($link);
mysqli_close($link);

if ($result) {
    $user = [
        "id" => $id,
        "name" => $name,
        "email" => $email,
        "grade" => $grade,
        "role" => Status::student
    ];
    return_ok($user, 200);
} else {
    return_error("Ученик не добавлен", 400);
}
```
При нажатии на кнопку "Удалить" через метод fetch (student.js) будут отпралены данные на сервер. На сервере производится удаление данных в одной из таблиц `teachers`, `students`, `subjects` (в зависимости от принадлежности кнопки к какому-то статусу). При успешном ответе от сервера в одной из таблиц `teachers`, `students`, `subjects будет удалено запрашиваемое поле, иначе возвращается ошибку.
1. admin.js
```js
function deleteRow(id, url, table) {
    fetch(BASE_API_URL + 'admin/' + url + '?id=' + id)
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                console.log(data);
                return;
            }
            const tableBody = document.getElementById(table + '-table');
            const row = document.getElementById(table + '-' + id);
            tableBody.removeChild(row);
        })
        .catch(error => {
            console.log(error);
        });
}
```
2. deleteStudent.php
```php
$id = $_GET['id'];

$link = new Database();
$link = $link->connect();

// Удаляем студента из базу данных 
$query = "DELETE FROM `students` WHERE `student_id` = $id";
$result = mysqli_query($link, $query);
mysqli_close($link);

if ($result) {
    return_ok("Ученик удалён", 200);
} else {
    return_error("Ученик не удалён", 400);
}
```
### Алгоритм добавления и удаления задания
Данные с формы отправляются на сервер через метод fetch (teacher.js). На сервере производится добавление данных в таблицу `exercises` (createExercise.php). При успешном ответе от сервера в таблице `exercises` появится новое поле, иначе возвращается ошибку.
1. teacher.js
```js
function getExercises(subject_id) {
    window.Subject_id = subject_id;

    const middleColumn = document.getElementById('middle-column');
    middleColumn.style.visibility = 'visible';

    const rightColumn = document.getElementById('right-column');
    rightColumn.style.visibility = 'hidden';

    const exercisesCards = document.getElementById('exercises-cards');
    exercisesCards.innerHTML = "";

    
    fetch(BASE_API_URL + 'teacher/getExercises.php?subject_id=' + subject_id)
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                console.log(data);
                return;
            }
            createExerciseCard(data.result);
        })
        .catch(error => {
            console.log(error);
        });
}
```
2. createExercise.php
```php
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
```
При нажатии на кнопку "Удалить" через метод fetch (teacher.js) будут отпралены данные на сервер. На сервере производится удаление данных в таблице `exercises`. При успешном ответе от сервера в таблице `exercises` будет удалено запрашиваемое поле, иначе возвращается ошибку.
1. teacher.js
```js
function deleteExercise(exercise_id) {
    fetch(BASE_API_URL + 'teacher/deleteExercise.php?exercise_id=' + exercise_id)
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                console.log(data);
                return;
            }
            const exerciseCard = document.getElementById('exercise-' + exercise_id);
            exerciseCard.remove();
        })

        .catch(error => {
            console.log(error);
        });
}
```
2. adfs
```php
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
```
### Алгоритм добавления и изменения оценки
Данные с формы отправляются на сервер через метод fetch (teacher.js). На сервере производится добавление данных в таблицу `tasks_grades` (getTasksGrades.php). При успешном ответе от сервера в таблице `tasks_grades` появится новое поле, иначе возвращается ошибку.
1. teacher.js
```js
function getTaskGrades(exercise_id, grade_name) {
    const rightColumn = document.getElementById('right-column');
    rightColumn.style.visibility = 'visible';

    fetch(BASE_API_URL + 'teacher/getTasksGrades.php?exercise_id=' + exercise_id + '&grade_name=' + grade_name)
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                console.log(data);
                return;
            }
            createStudentRow(data.result, exercise_id);
        })
        .catch(error => {
            console.log(error);
        });
}
```
2. getTasksGrades.php
```php
$exercise_id = $_GET['exercise_id'];
$grade_name = $_GET['grade_name'];

$teacher_id = unserialize($_SESSION['user'])->id;

$link = new Database();
$link = $link->connect();


$query = "SELECT * FROM exercises WHERE exercise_id = '$exercise_id' AND teacher_id = '$teacher_id'";
$result = check_query(mysqli_query($link, $query), 'Ошибка при подключении к базе данных', 500);
check_query(mysqli_num_rows($result), 'Нет такого задания от учителя', 400);


$query = "SELECT * FROM subjects WHERE grade_name = '$grade_name' AND teacher_id = '$teacher_id'";
$result = check_query(mysqli_query($link, $query), 'Ошибка при подключении к базе данных', 500);
check_query(mysqli_num_rows($result), 'Нет такой оценки от учителя', 400);


$query = "SELECT students.*, tasks_grades.task_grade FROM students
    LEFT JOIN tasks_grades ON students.student_id = tasks_grades.student_id AND tasks_grades.exercise_id = '$exercise_id' 
    WHERE students.grade_name = '$grade_name'";
$result = check_query(mysqli_query($link, $query), 'Ошибка при подключении к базе данных', 500);

$tasks_grades = [];
while($row = mysqli_fetch_assoc($result)) {
    $task_grade = [
        'student_id' => $row['student_id'],
        'student_name' => $row['student_name'],
        'task_grade' => $row['task_grade']
    ];
    array_push($tasks_grades, $task_grade);
}

mysqli_close($link);

return_ok($tasks_grades, 200);
```
Данные с формы отправляются на сервер через метод fetch (teacher.js). На сервере производится изменение данных в таблице `tasks_grades` (changeTasksGrades.php). При успешном ответе от сервера в таблице `tasks_grades` обновится одно из полей, иначе возвращается ошибку.
1. teacher.js
```js
function changeTaskGrades(student_id, exercise_id, task_grade) {
    fetch(BASE_API_URL + 'teacher/changeTasksGrades.php?exercise_id=' + exercise_id + '&student_id='+student_id+'&task_grade=' + task_grade)
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                console.log(data);
                return;
            }
        })
        .catch(error => {
            console.log(error);
        });
}
```
2. changeTasksGrades.php
```php
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
```
