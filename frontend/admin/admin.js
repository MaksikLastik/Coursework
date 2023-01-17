const createTeacherButton = document.querySelector('#create-teacher-btn');
const createStudentButton = document.querySelector('#create-student-btn');
const createSubjectButton = document.querySelector('#create-subject-btn');

// Добавление прослушивания событий щелчка к кнопкам создания
createTeacherButton.addEventListener('click', toggleForm);
createStudentButton.addEventListener('click', toggleForm);
createSubjectButton.addEventListener('click', toggleForm);
createSubjectButton.addEventListener('click', updateTeachersSelector);

// я хз
function updateTeachersSelector() {
    const teacherSelector = document.getElementById('select-teacher');
    teacherSelector.innerHTML = '';
    fetch(BASE_API_URL + 'admin/teachers/listTeachers.php')
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                console.log(data);
                return;
            }
            const teachers = data.result;
            teachers.forEach(teacher => {
                const option = document.createElement('option');
                option.value = teacher.id;
                option.textContent = teacher.name;
                teacherSelector.appendChild(option);
            });
        })
        .catch(error => {
            console.log(error);
        });
}

// Переключение кнопки для для скрытия и появления формы для заполнения данных
function toggleForm(e) {
    e.preventDefault();

    const button = e.target;
    const formId = button.id.replace('-btn', '-form');
    console.log(formId);
    const form = document.querySelector(`#${formId}`);
    if (form.style.display === 'block') {
        form.style.display = 'none';
    } else {
        form.style.display = 'block';
    }

    const closeButton = form.querySelector('.close-btn');

    closeButton.addEventListener('click', e => {
        form.style.display = 'none';
    });
}

const addTeacherButton = document.getElementById('submit-teacher');
const addStudentButton = document.getElementById('submit-student');
const addSubjectButton = document.getElementById('submit-subject');



addTeacherButton.addEventListener('click', e => {
    e.preventDefault();

    const form = e.target.form;

    const emailInput = form.elements.email;
    const passwordInput = form.elements.password;
    const nameInput = form.elements.name;

    const email = emailInput.value;
    const password = passwordInput.value;
    const name = nameInput.value;

    
    const params = new URLSearchParams();
    params.append('email', email);
    params.append('password', password);
    params.append('name', name);


    fetch(BASE_API_URL + 'admin/teachers/addTeacher.php?' + params)
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                console.log(data);
                return;
            }
            const teacher = {
                id: data.result.id,
                email: data.result.email,
                name: data.result.name
            };
            createTeacherRow([teacher]);
        })
        .catch(error => {
            console.log(error);
        });
});

// Добавление прослушивания событий щелчка к кнопке добавления ученика
addStudentButton.addEventListener('click', e => {
    e.preventDefault();

    const form = e.target.form;

    const emailInput = form.elements.email;
    const passwordInput = form.elements.password;
    const nameInput = form.elements.name;
    const gradeInput = form.elements.grade;

    const email = emailInput.value;
    const password = passwordInput.value;
    const name = nameInput.value;
    const grade = gradeInput.value;

    const params = new URLSearchParams();
    params.append('email', email);
    params.append('password', password);
    params.append('name', name);
    params.append('grade', grade);


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

// Добавление прослушивания событий щелчка к кнопке добавления предмета
addSubjectButton.addEventListener('click', e => {
    e.preventDefault();

    const form = e.target.form;

    const nameInput = form.elements.name;
    const gradeInput = form.elements.grade;
    const teacherInput = form.elements.teacher;

    const name = nameInput.value;
    const grade = gradeInput.value;
    const teacher = teacherInput.value;

    const params = new URLSearchParams();
    params.append('teacher', teacher);
    params.append('name', name);
    params.append('grade', grade);

    fetch(BASE_API_URL + 'admin/subjects/addSubject.php?' + params)
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                console.log(data);
                return;
            }
            const subject = {
                id: data.result.id,
                name: data.result.name,
                grade: data.result.grade,
                teacher: data.result.teacher
            };
            createSubjectRow([subject]);
        })
        .catch(error => {
            console.log(error);
        });
});

// функция удаления 
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

// Добавление нового учителя в базу данных
function createTeacherRow(teachers){
    const tableBody = document.getElementById('teacher-table');
    teachers.forEach(teacher => {
        const newRow = document.createElement('tr');
        newRow.setAttribute('id', 'teacher-'+teacher.id);
        newRow.innerHTML = `
            <td class="bg-blue-600 border px-4 py-2 w-1/3">${teacher.name}</td>
            <td class="bg-blue-600 border px-4 py-2 w-1/3">${teacher.email}</td>
            <td class="bg-blue-600 border px-4 py-2 w-1/3">
                <button id="delete-teacher" onclick="deleteRow(${teacher.id}, 'teachers/deleteTeacher.php', 'teacher');" 
                    class="px-4 py-2 bg-red-500 text-gray-200 hover:bg-red-600 hover:text-white rounded-full focus:outline-none 
                    focus:shadow-outline-gray active:bg-red-600">Удалить</button>
            </td>
        `;
        tableBody.appendChild(newRow);
    });
}

// Добавления нового студента в базу данных
function createStudentRow(students){
    const tableBody = document.getElementById('student-table');
    students.forEach(student => {
        const newRow = document.createElement('tr');
        newRow.setAttribute('id', 'student-'+student.id);
        newRow.innerHTML = `
            <td class="bg-blue-600 border px-4 py-2 w-1/4">${student.name}</td>
            <td class="bg-blue-600 border px-4 py-2 w-1/4">${student.email}</td>
            <td class="bg-blue-600 border px-4 py-2 w-1/4">${student.grade}</td>
            <td class="bg-blue-600 border px-4 py-2 w-1/4">
                <button id="delete-student" onclick="deleteRow(${student.id}, 'students/deleteStudent.php', 'student');" 
                    class="px-4 py-2 bg-red-500 text-gray-200 hover:bg-red-600 hover:text-white rounded-full focus:outline-none 
                    focus:shadow-outline-gray active:bg-red-600">Удалить</button>
            </td>
        `;
        tableBody.appendChild(newRow);
    });
}

// Добавление нового предмета в базу данных
function createSubjectRow(subjects){
    const tableBody = document.getElementById('subject-table');
    subjects.forEach(subject => {
        const newRow = document.createElement('tr');
        newRow.setAttribute('id', 'subject-'+subject.id);
        newRow.innerHTML = `
            <td class="bg-blue-600 border px-4 py-2 w-1/4">${subject.name}</td>
            <td class="bg-blue-600 border px-4 py-2 w-1/4">${subject.grade}</td>
            <td class="bg-blue-600 border px-4 py-2 w-1/4">${subject.teacher}</td>
            <td class="bg-blue-600 border px-4 py-2 w-1/4">
                <button id="delete-subject" onclick="deleteRow(${subject.id}, 'subjects/deleteSubject.php', 'subject');" 
                    class="px-4 py-2 bg-red-500 text-gray-200 hover:bg-red-600 hover:text-white rounded-full focus:outline-none 
                    focus:shadow-outline-gray active:bg-red-600">Удалить</button>
            </td>
        `;
        tableBody.appendChild(newRow);
    });
}

// Получение из базы данных учителей и вывод их на экран
function getTeachers() {
    fetch(BASE_API_URL + 'admin/teachers/listTeachers.php')
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                console.log(data);
                return;
            }
            createTeacherRow(data.result);
        })
        .catch(error => {
            console.log(error);
        });
}

// Получение из базы данных учеников и вывод их на экран
function getStudents() {
    fetch(BASE_API_URL + 'admin/students/listStudents.php')
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                console.log(data);
                return;
            }
            createStudentRow(data.result);
        })
        .catch(error => {
            console.log(error);
        });
}

// Получение из базы данных предметов и вывод их на экран
function getSubjects() {
    fetch(BASE_API_URL + 'admin/subjects/listSubjects.php')
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                console.log(data);
                return;
            }
            createSubjectRow(data.result);
        })
        .catch(error => {
            console.log(error);
        });
}

getTeachers();
getStudents();
getSubjects();