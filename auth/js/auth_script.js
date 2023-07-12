function saveChanges()
{
    // заберём из формы заполненные поля
    let formData = $('#save-changes-btn').serializeArray();

    // сформируем объект с данными для отправки ajax-ом
    let objData = {};
    for (var obj in formData) {
        objData[formData[obj]['name']] = formData[obj]['value'];
    }
    objData['time_difference'] = $("#hours-difference :selected").text();
    objData['notification'] = Number(document.getElementById('alert').checked);

    // отправляем
    $.ajax({
        url: '/auth/ajax_change_data.php',
        method: 'post',
        dataType: 'html',
        data: objData,
        success: function(data){
            console.log(data);
        }
    });
}

let changePasswordBtn = document.querySelector('#change-password-btn');
changePasswordBtn.addEventListener('click', function() {
    $oldPassword = document.getElementById('old-password').value;
    $newPassword = document.getElementById('new-password').value;
    $.ajax({
        url: '/auth/ajax_password_check.php',
        method: 'post',
        dataType: 'html',
        data: {
            'old_password': $oldPassword,
            'new_password': $newPassword
        },
        success: function(data){
            alert(data);
            // if (data) {
            //     // открыть модалку, что пароль успешно изменён
            // } else {
            //     let divOldPassword = document.querySelector('[data-field="old_password"]');
            //     let inputOldPassword = document.querySelector('#old-password');
            //     let textMessage = document.createElement('div');
            //     textMessage.innerHTML = 'Неверный пароль';
            //     textMessage.classList.add('text-response', 'error');
            //     // textMessage.style.color = '#D82500';
            //     // inputOldPassword.style.border = '#D82500';
            //     // divOldPassword.append(textMessage);
            //     divOldPassword.insertAdjacentHTML('afterEnd', textMessage.outerHTML)
            //     // divOldPassword.parentNode.insertBefore(textMessage, divOldPassword);
            // }
        }
    });
});

