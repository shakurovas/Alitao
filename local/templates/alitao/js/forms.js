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






/*Десктот форма авторизации*/
const deskSingInForm = document.querySelector('form[data-target="desktop-sing-in"]');

/*Десктот форма регистрации*/
const deskSingUpForm = document.querySelector('form[data-target="desktop-sing-up"]');

/*Десктот форма Восстановления*/
const deskRecoveryForm = document.querySelector('form[data-target="desktop-recovery"]');

/*Десктот форма сброса пароля*/
const deskResetPasswordForm = document.querySelector('form[data-target="desktop-reset-password"]');

/*Десктот форма смена пароля*/
const deskChangePasswordForm = document.querySelector('form[data-target="desktop-change-password"]');


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


/*Варианты ответов для Тестеровния*/
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
    deskSingInForm.addEventListener('submit', function(event){
        event.preventDefault();
        
        


        let data_body = 'login=' + this.login.value + "&password=" + this.password.value;
        
        fetch("script-name.php", {
            method: "POST",
            body: data_body,
            headers:{"content-type": "application/x-www-form-urlencoded"} 
        })
        .then( (response) => {
            if (response.status !== 200) {
                return Promise.reject();
            }
            this.password.value = "";
            this.login.value = "";
            

        })
        .then(i => console.log(i))
        .catch(() => {
            
            /*
                1. singInResponse заменить на response    
                2. Переместить блок кода в первый then
            */
            for (key in singInResponse) {


                let responseLine = singInResponse[key];
                let fieldWrap = this.querySelector('[data-field="'+key+'"]');
                
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

/* Отправка модальной формы регистрации */
if ( deskSingUpForm ){
    deskSingUpForm.addEventListener('submit', function(event){
        event.preventDefault();

        let data_body = 'login=' + this.login.value + "&password=" + this.password.value;
        
        fetch("script-name.php", {
            method: "POST",
            body: data_body,
            headers:{"content-type": "application/x-www-form-urlencoded"} 
        })
        .then( (response) => {
            if (response.status !== 200) {
                return Promise.reject();
            }
            this.password.value = "";
            this.login.value = "";
            

        })
        .then(i => console.log(i))
        .catch(() => {
            
            /*
                1. singUpResponse заменить на response    
                2. Переместить блок кода в первый then
            */
            for (key in singUpResponse) {


                let responseLine = singUpResponse[key];
                let fieldWrap = this.querySelector('[data-field="'+key+'"]');
                
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


/* Отправка формы восстановления пароля*/
if ( deskRecoveryForm ){
    deskRecoveryForm.addEventListener('submit', function(event){
        event.preventDefault();

        let data_body = 'login=' + this.login.value;
        
        fetch("script-name.php", {
            method: "POST",
            body: data_body,
            headers:{"content-type": "application/x-www-form-urlencoded"} 
        })
        .then( (response) => {
            if (response.status !== 200) {
                return Promise.reject();
            }
            this.login.value = "";
            

        })
        .then(i => console.log(i))
        .catch(() => {
            
            /*
                1. recoveryResponse заменить на response    
                2. Переместить блок кода в первый then
            */
            for (key in recoveryResponse) {


                let responseLine = recoveryResponse[key];
                let fieldWrap = this.querySelector('[data-field="'+key+'"]');
                
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


if ( deskResetPasswordForm ){
    deskResetPasswordForm.addEventListener('submit', function(event){
        event.preventDefault();

        if ( this.password.value ===  this.retype.value){

            let data_body = 'login=' + this.login.value + "&password=" + this.password.value;
        
            fetch("script-name.php", {
                method: "POST",
                body: data_body,
                headers:{"content-type": "application/x-www-form-urlencoded"} 
            })
            .then( (response) => {
                if (response.status !== 200) {
                    return Promise.reject();
                }
                this.login.value = "";
                this.password.value = "";
                
    
            })
            .then(i => console.log(i))
            .catch(() => {
                
                
            });


        } else{
            let fieldWrap = this.querySelector('[data-field="retype-password"]');
                
                
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
    deskChangePasswordForm.addEventListener('submit', function(event){
        event.preventDefault();

        let data_body = 'old_password=' + this.old_password.value + "&new_password=" + this.new_password.value;
        
        fetch("script-name.php", {
            method: "POST",
            body: data_body,
            headers:{"content-type": "application/x-www-form-urlencoded"} 
        })
        .then( (response) => {
            if (response.status !== 200) {
                return Promise.reject();
            }
            this.password.value = "";
            this.login.value = "";
            

        })
        .then(i => console.log(i))
        .catch(() => {
            
            /*
                1. singUpResponse заменить на response    
                2. Переместить блок кода в первый then
            */
            for (key in changePasswordResponse) {


                let responseLine = changePasswordResponse[key];
                let fieldWrap = this.querySelector('[data-field="'+key+'"]');
                
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
    moOrderRemoveBtns.forEach( btn => {
        btn.addEventListener('click', function(){
            
            const parent = this.closest('.mo-order');
            parent.remove();


            let activeOrders = document.querySelectorAll('.mo-order');

            if ( !activeOrders.length ){
                document.querySelector('.order-calc-block').classList.add('d-none');
                document.querySelector('.mo-instructions').classList.remove('d-none');
                
            }
        })
    })

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

let btnAddProduct = document.querySelectorAll('.btn-add-product');

if ( btnAddProduct.length ){
           
    btnAddProduct.forEach( btn => {
        btn.addEventListener('click', function(){
        
            const pageInputValue = document.querySelector('[name = "mo-product-link"]').value;                    
            const modalInput = document.querySelector('[name = "product_link"]'); 
            modalInput.value = pageInputValue;
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

