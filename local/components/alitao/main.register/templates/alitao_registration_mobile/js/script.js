// делаем так, чтоб кнопка "зарегистрироваться" в мобильной версии была неактивна, если пользователь
// убрал галочку в чекбоксе "Я даю согласие на обработку персональных данных"

let agreeCheckbox = document.querySelector('.agree-checkbox-mobile');
let signUpBtn = document.querySelector('.sign-up-button-mobile');

if (typeof agreeCheckbox !== 'undefined' && agreeCheckbox != null && signUpBtn != null && typeof signUpBtn !== 'undefined') {
    agreeCheckbox.addEventListener('change', function() {
        console.log(agreeCheckbox.checked);
        if (!agreeCheckbox.checked) {
            signUpBtn.disabled = true;
        } else {
            signUpBtn.disabled = false;
        }
    });
}
