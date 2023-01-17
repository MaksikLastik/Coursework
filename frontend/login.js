const form = document.querySelector('form');
const errorBox = document.querySelector('.error-box');


// Отправка формы для входа в аккаунт
form.addEventListener('submit', e => {
    e.preventDefault();

    const email = form.email.value;
    const password = form.password.value;
    const role = form.role.value;

    const params = new URLSearchParams();
    params.append('email', email);
    params.append('password', password);
    params.append('role', role);

    // В зависимости от выбора статуса пользователя перейдет на его страничку
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
        // Иначе выведет ошибку
        .catch(error => {
            errorBox.textContent = 'Неверная почта или пароль или сервер не отвечает';
            errorBox.style.display = 'block';
            console.log(error);
        });
});

