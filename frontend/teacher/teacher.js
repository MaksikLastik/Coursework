var Subject_id;

// Создает форму карточки одного из предметов, преподаваемых этим учителем
function createSubjectCard(subjects) {
    const leftColumnBody = document.getElementById('subjects-cards');

    subjects.forEach(subject => {
        const newCard = document.createElement('div');
        newCard.setAttribute('id', 'subject-' + subject.id);
        newCard.setAttribute('class', "p-4 bg-blue-800 dark:bg-gray-700 rounded-lg mb-4 flex justify-between");
        newCard.innerHTML = `
            <h3 class="text-xl font-bold mb-2 text-gray-100 dark:text-gray-800">${subject.name} ${subject.grade}</h3>
            <button class="bg-purple-700 dark:bg-gray-500 rounded-lg px-4 py-2 text-gray-100 dark:text-gray-800 font-bold" 
                onclick="getExercises(${subject.id})">Открыть</button>
        `;
        leftColumnBody.insertAdjacentElement("afterbegin", newCard);
    });
}

// Создает форму карточки одного из заданий по одному предмету этого учителя
function createExerciseCard(exercises) {
    const middleColumnBody = document.getElementById('exercises-cards');

    exercises.forEach(exercise => {
        const newCard = document.createElement('div');
        newCard.setAttribute('id', 'exercise-' + exercise.id);
        newCard.setAttribute('class', "p-4 bg-blue-800 dark:bg-gray-700 rounded-lg mb-4 flex justify-between");
        newCard.innerHTML = `
            <h3 class="text-xl font-bold mb-2 text-gray-100 dark:text-gray-800">${exercise.name}</h3>
            <p class="text-gray-100 dark:text-gray-800">${exercise.text}</p>
            <button class="bg-red-600 dark:bg-red-500 rounded-lg px-4 py-2 text-red-100 dark:text-red-800 font-bold" 
                onclick="deleteExercise(${exercise.id})">Удалить</button>
            <button class="bg-purple-700 dark:bg-gray-500 rounded-lg px-4 py-2 text-gray-100 dark:text-gray-800 font-bold" 
                onclick="getTaskGrades(${exercise.id}, '${exercise.grade}')">Открыть</button>
        `;
        middleColumnBody.insertAdjacentElement("afterbegin", newCard);
    });
}

// Получение с базы данных предметов и вывод их на экран
function getSubjects() {
    fetch(BASE_API_URL + 'teacher/getSubjects.php')
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                console.log(data);
                return;
            }
            createSubjectCard(data.result);
        })
        .catch(error => {
            console.log(error);
        });
}

// Получение с базы данных заданий по определенному предмету и вывод их на экран
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

// Получение с базы данных таблицы оценок по заданию определенного предмета учителя и вызов createStudentRow(data.result, exercise_id);
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

// Функция для выставления оценки за задание (отправляет ее в базу данных)
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

// Создание формы карточки для оценивания учеников за задание по определённому предмету учителя 
function createStudentRow(students, exercise_id) {
    const tableBody = document.getElementById('student-table');
    tableBody.innerHTML = "";

    students.forEach(student => {
        const newRow = document.createElement('tr');
        newRow.setAttribute('id', 'student-' + student.student_id);
        newRow.innerHTML = `
            <td class="p-4 border border-gray-600 dark:border-gray-200 bg-blue-600 dark:bg-gray-800 text-gray-100 dark:text-gray-800">
                ${student.student_name}</td>
            <td class="text-center p-4 border border-gray-600 dark:border-gray-200 bg-blue-600 dark:bg-gray-800 text-gray-100 dark:text-gray-800">
                <select id="select-${student.student_id}" class="text-center p-2 border border-gray-600 dark:border-gray-200 bg-purple-700 
                    dark:bg-gray-800 text-gray-100 
                    dark:text-gray-800 rounded-lg" onchange="changeTaskGrades(${student.student_id}, ${exercise_id}, this.value);">
                    <option value="">${student.task_grade}</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </td>
        `;
        tableBody.appendChild(newRow);
    });
}

// Удаление формы карточки задания (и из базы данных)
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

const addExercise = document.getElementById('add-exercise');

// Добавление новой формы карточки зпдпния по одному предмету этого учителя 
addExercise.addEventListener('click', (e) => {
    e.preventDefault();
    const form = e.target.form;

    const nameInput = form.elements.name;
    const textInput = form.elements.text;

    const name = nameInput.value;
    const text = textInput.value;

    const data = new URLSearchParams();
    data.append('subject_id', Subject_id);
    data.append('name', name);
    data.append('text', text);


    fetch(BASE_API_URL + 'teacher/createExercise.php?' + data)
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                console.log(data);
                return;
            }
            createExerciseCard([data.result]);
        })
        .catch(error => {
            console.log(error);
        });
});

getSubjects();
