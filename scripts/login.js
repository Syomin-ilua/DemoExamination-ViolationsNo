const auth__form = document.querySelector(".form__auth");

const loginInput = document.getElementById('login');
const passwordInput = document.getElementById('password');

const loginText = document.querySelector(".placeholder__text_login");
const passwordText = document.querySelector(".placeholder__text_password");

const loginInvalidParagraph = document.getElementById("input-login-invalid");
const passwordInvalidParagraph = document.getElementById("input-password-invalid");

function loginValidator(login) {
    if (login.length <= 3) {
        loginInvalidParagraph.innerText = 'Логин не должен быть меньше 4 символов!';
        loginInput.style.cssText = `
            color: red;
            border-bottom: 1px solid red;
        `;
        loginText.style.color = "red";
        return false;
    }

    loginInvalidParagraph.innerText = "";
    loginInput.style.cssText = ``;
    loginText.style.color = "";
    return true;
}

function passwordValidator(password) {
    if (password.length <= 7) {
        passwordInvalidParagraph.innerText = 'Пароль не должен быть меньше 8 символов!';
        passwordInput.style.cssText = `
            color: red;
            border-bottom: 1px solid red;
        `;
        passwordText.style.color = "red";
        return false;
    }

    passwordInvalidParagraph.innerText = "";
    passwordInput.style.cssText = ``;
    passwordText.style.color = "";
    return true;
}

loginInput.addEventListener('blur', (event) => {
    const login = event.target.value.trim();
    loginValidator(login);
});

passwordInput.addEventListener('blur', (event) => {
    const password = event.target.value.trim();
    passwordValidator(password);
});

loginInput.addEventListener('input', (event) => {
    const login = event.target.value.trim();
    loginValidator(login);
});

passwordInput.addEventListener('input', (event) => {
    const password = event.target.value.trim();
    passwordValidator(password);
});

auth__form.addEventListener('submit', (event) => {
    
    const loginValue = document.getElementById('login').value.trim();
    const passwordValue = document.getElementById('password').value.trim();
    
    const loginValid = loginValidator(loginValue);
    const passwordValid = passwordValidator(passwordValue);
    
    if (loginValid === false || passwordValid === false) {
        event.preventDefault();
        return false;
    }
});

