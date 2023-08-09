// для сохранения изменений при редактировании профиля
function saveChanges(event)
{
  event.preventDefault();

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
      url: '/auth/ajax/ajax_change_data.php',
      method: 'post',
      dataType: 'html',
      data: objData,
      success: function(data){
          console.log(data);
          window.location.href = '/auth/personal.php';
      }
  });
}


// очищение полей старого и нового пароля при нажатии на кнопку "закрыть окно"
let changePasswordCloseBtn = document.querySelector('#change-password-close');
if (typeof changePasswordCloseBtn !== 'undefined' && changePasswordCloseBtn != null) {
    changePasswordCloseBtn.addEventListener('click', function() {
        document.getElementById('old-password').value = '';
        document.getElementById('new-password').value = '';

        let textResponseLines = document.querySelectorAll('.text-response');
        for (let i=0; i < textResponseLines.length; i++) {
            if (typeof textResponseLines[i] !== 'undefined' && textResponseLines[i] != null) 
            textResponseLines[i].remove();
        }
        document.getElementById('old-password').style.border = '1px solid #959595';
        document.getElementById('new-password').style.border = '1px solid #959595';
    });
}


// сохранение нового загруженного фото
let changePhotoBtn = document.querySelector('#change-photo-btn');
changePhotoBtn.addEventListener('click', function(event) {
    $.ajax( {
      url: '/auth/ajax/ajax_change_photo.php',
      type: 'POST',
      data: new FormData($("#change-photo")[0]),
      processData: false,
      contentType: false,
      enctype: 'multipart/form-data',
      success: function(data) {
        // обрабатываем возможные ошибки, останавливаем отправку формы и выводим сообщения об ошибках
        if (data == 'INVALID_FILE_SIZE'){  // уведомление о том, что превышен размер файла
          event.preventDefault();
          alert('Размер фото превышает допустимый');
        } else if (data =='INVALID_FILE_TYPE'){  // уведомление о том, что не тот тип файла (не картинка)
          event.preventDefault();
          alert('Загружаемый файл должен быть изображением');  
        } else if (data == 'NO_PHOTO_ADDED') {  // уведомление о том, что файл не загружен
          event.preventDefault();
          alert('Вы не загрузили фото');
        } else if (data == 'SOMETHING_WENT_WRONG') {  // уведомление о том, что что-то пошло не так по какой-то другой причине, не перечисленной выше
          event.preventDefault();
          alert('Что-то пошло не так. Попробуйте снова или загрузите другой файл');
        }
      }
    }); 
})