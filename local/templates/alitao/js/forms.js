let resetPasswordModal;
if ( document.getElementById('resetPassword') ){
    resetPasswordModal = new bootstrap.Modal(document.getElementById('resetPassword'), {
        keyboard: false
    })
}



function extractGet(name) {
  let result = window.location.search.match(new RegExp(name + '=([^&=]+)'));
  return result ? result[1] : false;
}


//Страница загрузилась
document.addEventListener('DOMContentLoaded', function(){
    //1.
    //Ищем на странице чек-боксы связанные с submit-кнопками форм
    //Если пользователь не согласен с обработкой,  кнопка становится disabled

    const linkingChecboxes = document.querySelectorAll('input[data-target-btn]');
    if ( linkingChecboxes.length ){
        
        linkingChecboxes.forEach( cb => {
            let targetBtn = cb.getAttribute('data-target-btn');
            let targetBtnNode = document.querySelector(targetBtn);
            
            if ( !cb.checked ) targetBtnNode.setAttribute('disabled', 'disabled');

            cb.addEventListener( 'change', function(){
                if ( !this.checked ) {
                    targetBtnNode.setAttribute('disabled', 'disabled');
                } else{
                    targetBtnNode.removeAttribute('disabled');
                }
            } )
        } )
    }

    if ( extractGet('recovery') ){
        resetPasswordModal.show();
    }
})






/*Десктоп форма авторизации*/
const deskSingInForm = document.querySelectorAll('form[data-target="desktop-sing-in"]');

/*Десктоп форма регистрации*/
const deskSingUpForm = document.querySelectorAll('form[data-target="desktop-sing-up"]');

/*Десктоп форма Восстановления*/
const deskRecoveryForm = document.querySelectorAll('form[data-target="desktop-recovery"]');

/*Десктоп форма сброса пароля*/
const deskResetPasswordForm = document.querySelector('form[data-target="desktop-reset-password"]');

/*Десктоп форма смена пароля*/
const deskChangePasswordForm = document.querySelectorAll('form[data-target="desktop-change-password"]');

/*Десктоп форма с вопросами*/
const deskQuestionsForm = document.querySelectorAll('form[data-target="desktop-send-question"]');



/*Обработчик скрытия ошибок по фокусу*/
const inputFormControls = document.querySelectorAll('input.form-control');
if (inputFormControls.length){
    inputFormControls.forEach( fc => {
        fc.addEventListener('focus', function(){            
            let wrap = this.closest('[data-field]');            
            if ( wrap ){
                
                let message = wrap.querySelector('.text-response');
                if (message && wrap.classList.contains('error') ){
                    message.remove();
                }
                wrap.classList.remove('error');
            }
        })
    } )
}


/*Варианты ответов для Тестирования*/
let singInResponse = {
    login: {
        state: "error",
        message: "Неверный Email"
    },
    password: {
        state: "error",
        message: "Неверный пароль"
    },
    
}

let singUpResponse = {
    login: {
        state: "error",
        message: "Почта уже используется"
    },    
    
}

let recoveryResponse = {
    login: {
        state: "success",
        message: "На вашу почту было отправлено письмо с инструкциями для восстановления пароля!"
    },    
    
}

let recoveryResponse2 = {
    login: {
        state: "error",
        message: "Пользователя с указанной почты не существует"
    },    
    
}

let changePasswordResponse = {
    old_password: {
        state: "error",
        message: "Неверный пароль"
    },    
    
}


/* Отправка модальной формы авторизации */
if ( deskSingInForm ){
    for (let i = 0; i < deskSingInForm.length; i++) {
        deskSingInForm[i].addEventListener('submit', function(event){
            event.preventDefault();
            
            let login = deskSingInForm[i].getElementsByTagName('div')[0].getElementsByTagName('input')[0].value;

            try {
                var password = deskSingInForm[i].getElementsByTagName('div')[2].getElementsByTagName('input')[0];
                if (typeof password === 'undefined') {
                    var password = deskSingInForm[i].getElementsByTagName('div')[1].getElementsByTagName('input')[0];
                }
            } catch(e) {
                var password = deskSingInForm[i].getElementsByTagName('div')[1].getElementsByTagName('input')[0];
                console.log(password);
            }
            
            let data_body = 'login=' + login + "&password=" + password.value;
            
            fetch("/auth/ajax/ajax_authorization.php", {
                method: "POST",
                body: data_body,
                headers:{"content-type": "application/x-www-form-urlencoded"} 
            })
            .then(function (response) {
                return response.text();
            })
            .then(function (response) {
                response = JSON.parse(response);
                console.log(response);
    
                for (key in response) {
                    if ((response[key]['state'] == 'success')) {
                        deskSingInForm[i].submit();
                        // window.location.href = "/auth/personal.php";
                    } else {
                        let responseLine = response[key];
                        let fieldWrap = deskSingInForm[i].querySelector('[data-field="'+key+'"]');
                        
                        let state = responseLine["state"];
                        let message = responseLine["message"];
        
                        if ( !fieldWrap.classList.contains(state) ){
                            fieldWrap.classList.add(state);
                            let textMessage = document.createElement('p');
                            textMessage.innerHTML = message;
                            textMessage.classList.add('text-response');
                            fieldWrap.append(textMessage);
                        }
                    }
                }
            });
        })
    }
}

/* Отправка модальной формы регистрации */
if ( deskSingUpForm ){
    for (let i = 0; i < deskSingUpForm.length; i++) {
        deskSingUpForm[i].addEventListener('submit', function(event){
            event.preventDefault();
    
            let data_body = 'login=' + deskSingUpForm[i].querySelector('#register-email').value + "&password=" + deskSingUpForm[i].querySelector('#register-password').value;
            
            fetch("/auth/ajax/ajax_registration.php", {
                method: "POST",
                body: data_body,
                headers:{"content-type": "application/x-www-form-urlencoded"} 
            })
            .then(function (response) {
                return response.text();
            })
            .then(function (response) {
                response = JSON.parse(response);
                console.log(response);
    
                for (key in response) {
                    if ((response[key]['state'] == 'success')) {
                        event.target.submit();
                    } else {
                        let responseLine = response[key];
                        let fieldWrap = deskSingUpForm[i].querySelector('[data-field="'+key+'"]');
                        
                        let state = responseLine["state"];
                        let message = responseLine["message"];
        
                        if ( !fieldWrap.classList.contains(state) ){
                            fieldWrap.classList.add(state);
                            let textMessage = document.createElement('p');
                            textMessage.innerHTML = message;
                            textMessage.classList.add('text-response');
                            fieldWrap.append(textMessage);
                        }
                    }
                }
            });
        })
    }
}

// если нажимают кнопку "закрыть", то окно восстановления пароля должно закрываться 
let passwordChangeBtnClose = document.querySelectorAll('.btn-close')[3];
let passwordChangeModal = document.querySelector('#resetPassword');

passwordChangeBtnClose.addEventListener('click', function() {
    passwordChangeModal.classList.remove("show");
    passwordChangeModal.style.display = 'none';
    passwordChangeModal.setAttribute('aria-hidden', 'true');
});


/* Отправка формы восстановления пароля*/
if ( deskRecoveryForm ){
    for (let i = 0; i < deskRecoveryForm.length; i++) {
        deskRecoveryForm[i].addEventListener('submit', function(event){
            event.preventDefault();
            // let login = deskRecoveryForm[i].getElementsByTagName('div')[0].getElementsByTagName('input')[0].value;
            // console.log(this.login.value);
    
            let data_body = 'login=' + this.login.value
            
            fetch("/auth/ajax/ajax_password_recovery.php", {
                method: "POST",
                body: data_body,
                headers:{"content-type": "application/x-www-form-urlencoded"} 
            })
            .then(function (response) {
                return response.text();
            })
            .then(function (response) {
                response = JSON.parse(response);
                console.log(response);
    
                for (key in response) {
                    let responseLine = response[key];
                    let fieldWrap = deskRecoveryForm[i].querySelector('[data-field="'+key+'"]');
                    // console.log(fieldWrap);
                    let state = responseLine["state"];
                    let message = responseLine["message"];
    
                    if ( !fieldWrap.classList.contains(state) ){
                        fieldWrap.classList.add(state);
                        let textMessage = document.createElement('p');
                        textMessage.innerHTML = message;
                        textMessage.classList.add('text-response');
                        fieldWrap.append(textMessage);
                    }
                }
            });
        })
    }
}


if ( deskResetPasswordForm ){
    deskResetPasswordForm.addEventListener('submit', function(event){
        event.preventDefault();
        // если пароль и повторение пароля совпадают
        if ( this.password.value ===  this.retype.value){

            let checkword = deskResetPasswordForm.getElementsByTagName('input')[1].value;
            let data_body = 'login=' + this.login.value + "&password=" + this.password.value + "&checkword=" + checkword;
        
            fetch("/auth/ajax/ajax_password_change.php", {
                method: "POST",
                body: data_body,
                headers:{"content-type": "application/x-www-form-urlencoded"} 
            })
            .then(function (response) {
                return response.text();
            })
            .then(function (response) {
                response = JSON.parse(response);
    
                for (key in response) {
                    let responseLine = response[key];
                    let fieldWrap = deskResetPasswordForm.querySelector('[data-field="'+key+'"]');
                    let state = responseLine["state"];
                    let message = responseLine["message"];

                    if ( !fieldWrap.classList.contains(state) ){
                        fieldWrap.classList.add(state);
                        let textMessage = document.createElement('p');
                        textMessage.innerHTML = message;
                        textMessage.classList.add('text-response');
                        fieldWrap.append(textMessage);
                    }
                }
            });
        // если пароль и повторение пароля не совпадают
        } else {
            let fieldWrap = deskResetPasswordForm.querySelector('[data-field="retype-password"]');
                
                
            if ( !fieldWrap.classList.contains('error') ){
                fieldWrap.classList.add('error');
                let textMessage = document.createElement('p');
                textMessage.innerHTML = 'Пароли не совпадают';
                textMessage.classList.add('text-response');
                fieldWrap.append(textMessage);
            }
        }
    })
}



/* Отправка модальной формы смены пароля */
if ( deskChangePasswordForm ){
    for (let i = 0; i < deskChangePasswordForm.length; i++) {
        deskChangePasswordForm[i].addEventListener('submit', function(event){
            event.preventDefault();
    
            let data_body = 'old_password=' + this.old_password.value + "&new_password=" + this.new_password.value;
            
            fetch("/auth/ajax/ajax_password_check.php", {
                method: "POST",
                body: data_body,
                headers:{"content-type": "application/x-www-form-urlencoded"} 
            })
            .then(function (response) {
                return response.text();
            })
            .then(function (response) {
                response = JSON.parse(response);
    
                // убираем строки с сообщениями до вывода новых и делаем цвет границы инпутов дефолтным (чтобы не выделялись красным)
                let textResponseLines = document.querySelectorAll('.text-response');
                for (let i=0; i < textResponseLines.length; i++) {
                    if (typeof textResponseLines[i] !== 'undefined' && textResponseLines[i] != null) 
                    textResponseLines[i].remove();
                }
    
                for (key in response) {
                    let responseLine = response[key];
                    let fieldWrap = deskChangePasswordForm[i].querySelector('[data-field="'+key+'"]');
                    
                    let state = responseLine["state"];
                    let message = responseLine["message"];
    
                    if ( !fieldWrap.classList.contains(state) ){
                        fieldWrap.classList.add(state);
                        let textMessage = document.createElement('p');
                        textMessage.innerHTML = message;
                        textMessage.classList.add('text-response');
                        fieldWrap.append(textMessage);
                    }
                }
            });
        })
    }
}


/* Отправка модальной формы с вопросом */
if ( deskQuestionsForm ){
    for (let i = 0; i < deskQuestionsForm.length; i++) {
        deskQuestionsForm[i].addEventListener('submit', function(event){
            event.preventDefault();

            let textResponseLines = deskQuestionsForm[i].querySelectorAll('.text-response');
            for (let i=0; i < textResponseLines.length; i++) {
                if (typeof textResponseLines[i] !== 'undefined' && textResponseLines[i] != null) 
                textResponseLines[i].remove();
            }
            
            let name = deskQuestionsForm[i].getElementsByTagName('div')[0].getElementsByTagName('input')[0].value;
            let contact = deskQuestionsForm[i].getElementsByTagName('div')[1].getElementsByTagName('input')[0].value;
            let question = deskQuestionsForm[i].getElementsByTagName('div')[2].getElementsByTagName('textarea')[0].value;

            if (name != '' && contact != '' && question != '') {
                let data_body = 'name=' + name + "&contact=" + contact + '&question=' + question;
            
                fetch("/ajax/ajax_questions_form.php", {
                    method: "POST",
                    body: data_body,
                    headers:{"content-type": "application/x-www-form-urlencoded"} 
                })
                .then(function (response) {
                    return response.text();
                })
                .then(function (response) {
                    response = JSON.parse(response);
                    console.log(response);
        
                    for (key in response) {
                        let responseLine = response[key];
                        let fieldWrap = deskQuestionsForm[i].querySelector('[data-field="'+key+'"]');
                        let state = responseLine["state"];
                        let message = responseLine["message"];
        
                        // console.log(fieldWrap);
                        if ( !fieldWrap.classList.contains(state) ){
                            fieldWrap.classList.add(state);
                            let textMessage = document.createElement('p');
                            textMessage.innerHTML = message;
                            textMessage.classList.add('text-response');
                            fieldWrap.append(textMessage);
                        }
                        // console.log(fieldWrap);
                    }
                });
            } else {  // если какое-то из полей не заполнено
                if (name == '') {
                    var fieldWrap = deskQuestionsForm[i].querySelector('[data-field="name"]');
                } else if (contact == '') {
                    var fieldWrap = deskQuestionsForm[i].querySelector('[data-field="contact"]');
                } else if (question == '') {
                    var fieldWrap = deskQuestionsForm[i].querySelector('[data-field="question"]');
                }
                
                if ( !fieldWrap.classList.contains('error') ){
                    fieldWrap.classList.add('error');
                    let textMessage = document.createElement('p');
                    textMessage.innerHTML = 'Заполните поле';
                    textMessage.classList.add('text-response');
                    fieldWrap.append(textMessage);
                }
            }
        })
    }
}


// при закрытии окна с вопросом очищаем все поля
let questionsModalCloseBtn = document.querySelector('#questions-modal-close');

questionsModalCloseBtn.addEventListener('click', function() {
    for (let i = 0; i < deskQuestionsForm.length; i++) {

        let textResponseLines = deskQuestionsForm[i].querySelectorAll('.text-response');
        for (let i=0; i < textResponseLines.length; i++) {
            if (typeof textResponseLines[i] !== 'undefined' && textResponseLines[i] != null) 
            textResponseLines[i].remove();
        }

        let fieldWraps = [
            deskQuestionsForm[i].querySelector('[data-field="name"]'),
            deskQuestionsForm[i].querySelector('[data-field="contact"]'),
            deskQuestionsForm[i].querySelector('[data-field="question"]')
        ];

        for (let i=0; i < fieldWraps.length; i++) {
            if (fieldWraps[i].classList.contains('error')){
                fieldWraps[i].classList.remove('error');
            }
            if (fieldWraps[i].classList.contains('success')){
                fieldWraps[i].classList.remove('success');
            }
        }

        deskQuestionsForm[i].getElementsByTagName('div')[2].getElementsByTagName('textarea')[0].value = '';
        deskQuestionsForm[i].querySelector('#sq-message').style.border = '#959595 1px solid';
    }
});


//Обработка изменения значения кастомного selecta
//за основу взят компонент BS 5 dropdown
const bs_dropdownItems = document.querySelectorAll('.dropdown-item.custom');
if ( bs_dropdownItems.length ){
    bs_dropdownItems.forEach( item => {

        item.addEventListener('click', function(){

            let parent = this.closest('.dropdown');
            let value = parent.querySelector('.value');
            
            if (value.innerHTML != this.innerHTML) {
                value.innerHTML = this.innerHTML;

                let changeSelectIndex = new Event("changeSelectIndex", {bubbles: true});                
                value.dispatchEvent(changeSelectIndex);

            }
        
        });


    })
}
document.addEventListener('changeSelectIndex', function(event){
    alert("alert в качестве подсказки.\r\n Значение:" + event.target.innerHTML + "\r\n код: 409 строка forms.js" + "\r\n \r\n срабатывает аналогично onChange стандартного select");    
})


let customTextAreas = document.querySelectorAll('.form-messages__text');
if ( customTextAreas.length ){
    customTextAreas.forEach( ta => {
        let placeholder = ta.getAttribute('data-placeholder');
        
        

        if ( ta.innerHTML === '' ){
            ta.innerHTML = placeholder;
            ta.classList.add('empty');
        }

        ta.addEventListener('focus', function (e) {
            const value = e.target.innerHTML;
            value === placeholder && (e.target.innerHTML = '');
            this.classList.remove('empty');
            
        });
        
        ta.addEventListener('blur', function (e) {
            const value = e.target.innerHTML;
            value === '' && (e.target.innerHTML = placeholder);

            if (value.length === 0  ){
                this.classList.add('empty');
            }
        });
    } )
}






let widgetIncs = document.querySelectorAll('.inc-widget__btn.inc');
let widgetDecs = document.querySelectorAll('.inc-widget__btn.dec');

if ( widgetIncs.length &&  widgetDecs.length ){
    widgetIncs.forEach( inc => {
        inc.addEventListener('click', function(){
            const parent = this.closest('.inc-widget');
            const field = parent.querySelector('input');
            let value = Number(field.value);
            value++;
            field.value = value; 
        })
    } )
    widgetDecs.forEach( dec => {
        dec.addEventListener('click', function(){
            const parent = this.closest('.inc-widget');
            const field = parent.querySelector('input');
            let value = Number(field.value);
            value--;
            if (value < 1)  value = 1;
            field.value = value; 
        })
    } )
}


const moOrderRemoveBtns = document.querySelectorAll('.mo-order__remove');
const moOrderEditBtns = document.querySelectorAll('.mo-order__edit');

if ( moOrderRemoveBtns.length && moOrderEditBtns.length){
    for (let i = 0; i < moOrderRemoveBtns.length; i++) {
        // moOrderRemoveBtns.forEach( btn => {
            moOrderRemoveBtns[i].addEventListener('click', function(){
                console.log(111);
                let linkOfGoodToDelete = document.querySelectorAll('.link-of-good')[i].href;
                

                $.ajax( {
                    url: '/order/ajax/ajax_remove_good.php',
                    method: 'POST',
                    dataType: 'html',
                    data: {link: linkOfGoodToDelete},
                    success: function(data) {
                      console.log(data);
                    }
                });


                const parent = this.closest('.mo-order');
                parent.remove();
    
    
                let activeOrders = document.querySelectorAll('.mo-order');
    
                if ( !activeOrders.length ){
                    document.querySelector('.order-calc-block').classList.add('d-none');
                    document.querySelector('.mo-instructions').classList.remove('d-none');
                    
                }

                // // если все заказы удалили, то нужно снова показать блок "добавить заказ с полем для ссылки"
                let moOrderRemoveBtnsMinus1 = document.querySelectorAll('.mo-order__remove');
                let instructionsBeforeGoodsHided = document.querySelector('.mo-instructions');
                if (!moOrderRemoveBtnsMinus1.length && instructionsBeforeGoodsHided) {
                    instructionsBeforeGoodsHided.style.display = 'block'; 
                }
            })
        // })
    }
    

    function sendValueInInput(parent, fieldName, fieldType = ''){
        const productValue = parent.querySelector('[data-target-field = "' +fieldName+ '"  ]').innerHTML;            
        const productInput = document.querySelector('[name = "' +fieldName+ '" ]'); 
        
        if (    fieldType === 'textarea' ){
            productInput.innerHTML = productValue;
        } else{
            
            productInput.value = productValue;
            
        }
        
    }

    moOrderEditBtns.forEach( btn => {
        btn.addEventListener('click', function(){            
            const parent = this.closest('.mo-order');
                
            sendValueInInput(parent, "product_name");
            sendValueInInput(parent, "product_color");
            sendValueInInput(parent, "product_size");
            sendValueInInput(parent, "product_comment", 'textarea');
            sendValueInInput(parent, "delivery_price", );
            sendValueInInput(parent, "product_price");
            
            let qty = parent.querySelector('input[name="product_qty"]').value;
            document.querySelector('.mo-modal input[name="product_qty"]').value = qty;
        })
    })
        
}

let btnAddProduct = document.querySelectorAll('.btn-add-product-before-goods');
console.log(btnAddProduct);
if ( btnAddProduct.length ){
           
    btnAddProduct.forEach( btn => {
        btn.addEventListener('click', function(){
            const pageInputValue = document.querySelector('[name = "mo-product-link"]').value;                    
            const modalInput = document.querySelector('[name = "product_link"]');
            modalInput.value = pageInputValue;
            console.log(pageInputValue);
        })
    } )

}


let removeUploadImgBtn = document.querySelectorAll('.products-photo-grid__item-remove');
let  productPhotoGrid =  document.querySelector('.products-photo-grid');



if ( productPhotoGrid ){

    productPhotoGrid.addEventListener('click', function(event){
        if (event.target.classList.contains('products-photo-grid__item-remove') || event.target.closest('.products-photo-grid__item-remove')  ){
            let productImgItem = event.target.closest('.products-photo-grid__item');
            productImgItem.remove();            
        }
    })

    
}

const inpProductPhoto = document.querySelector('input[name="product_photo"');
if ( inpProductPhoto ){
    inpProductPhoto.onchange = function(event) {
        var target = event.target;
    
        if (!FileReader) {
            
            return;
        }
    
        if (!target.files.length) {
            
            return;
        }
    
        var fileReader = new FileReader();
        fileReader.onload = function() {
            //img1.src = fileReader.result;

            const imgContainer = document.createElement('div');
            imgContainer.classList.add('products-photo-grid__item');
            productPhotoGrid.append(imgContainer);


            const removeBtn =  document.createElement('div');
            removeBtn.classList.add('products-photo-grid__item-remove');

            const removeBtnCross = document.createElement('img');
            removeBtnCross.src = "assets/img/icons/remove-product.svg";
            removeBtn.append(removeBtnCross);
            imgContainer.append(removeBtn);


            const img  = document.createElement('img');
            img.src = fileReader.result;
            imgContainer.append(img);
        }
    
        fileReader.readAsDataURL(target.files[0]);
    }
}

//маски телефонов
const phoneMasks = document.querySelectorAll("input[name='phone']");
if (phoneMasks.length){
    phoneMasks.forEach( (input) => {
        IMask(
            input, {
              mask: '+{7} 000 000-00-00'
              
          });
    })
}

//маски почтового индекса
const zipIndex = document.querySelectorAll("input[name='zipindex']");
if (zipIndex.length){
    zipIndex.forEach( (input) => {
        IMask(
            input, {
              mask: '000 000'
              
          });
    })
}



// обновление времени
let pekingTime = document.querySelector('#peking-time');
let moscowTime = document.querySelector('#moscow-time');

setInterval(function() {
    $.ajax( {
        url: '/ajax/ajax_time_updater.php',
        method: 'POST',
        dataType: 'html',
        data: {},
        success: function(data) {
          data = JSON.parse(data);
          pekingTime.innerHTML = data['peking_time'];
          moscowTime.innerHTML = data['moscow_time'];
        }
    });
}, 60000);