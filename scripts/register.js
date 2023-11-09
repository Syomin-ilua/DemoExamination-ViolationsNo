const phoneRegExp = new RegExp(/^(\+7|8)?(\d{10})$/);
const emailRegExp = new RegExp(/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/);

const formRegistration = document.querySelector(".form__registration");

const emailText = document.getElementById("placeholder-text-email");
const phoneText = document.getElementById("placeholder-text-tel");
const emailInput = document.getElementById("email");
const phoneInput = document.getElementById("phone");

const invalidParagraphEmail = document.getElementById("input-email-invalid");
const invalidParagraphTel = document.getElementById("input-tel-invalid");

emailInput.addEventListener('input', function (event) {
    const email = event.target.value;
    validateEmail(email);
});

phoneInput.addEventListener('input', function (event) {
    const tel = event.target.value;
    validateTel(tel);
});


function validateTel(tel) {

    if (!phoneRegExp.test(tel)) {
        invalidParagraphTel.innerText = "Введите правильно номер телефона!"
        phoneInput.style.cssText = `
            color: red;
            border-bottom: 1px solid red;
        `;
        phoneText.style.color = "red";
        return false;
    } else {
        invalidParagraphTel.innerText = "";
        phoneInput.style.cssText = ``;
        phoneText.style.color = "";
        return true;
    }
}

function validateEmail(email) {

    if (!emailRegExp.test(email)) {
        invalidParagraphEmail.innerText = "Введите правильно почту!"
        emailInput.style.cssText = `
            color: red;
            border-bottom: 1px solid red;
        `;
        emailText.style.color = "red";
        return false;
    }
    else {
        invalidParagraphEmail.innerText = "";
        emailInput.style.cssText = ``;
        emailText.style.color = "";
        return true;
    }
}

formRegistration.addEventListener("submit", function (event) {

    const email = document.getElementById("email").value;
    const tel = document.getElementById("phone").value;
    
    const validTel = validateTel(tel);
    const validEmail = validateEmail(email);

    if (validTel === false || validEmail === false) {
        event.preventDefault();
        return false;
    }
    
    return true;

});

