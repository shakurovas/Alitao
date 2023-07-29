// STEP 1


// let addGoodsBtnCart = document.querySelectorAll('.add-goods-btn-cart');
// for (let i = 0; i < addGoodsBtnCart.length; i++) {
//   addGoodsBtnCart[i].addEventListener('click', function() {
    // document.querySelector('#product-link').value = ''; 
    // document.querySelector('#product-name').value = ''; 
    // document.querySelector('#product-price').value = ''; 
    // document.querySelector('#product-size').value = ''; 
    // document.querySelector('#delivery-price').value = ''; 
    // document.querySelector('#product-color').value = ''; 
    // document.querySelector('#product-comment').value = ''; 
    // document.querySelector('#product-qty').value = ''; 
    // document.querySelector('input[name="files[]"').value = ''; 
    // document.querySelector('#photoreport').checked = true; 
    
    // let modalBackDropDiv = document.querySelector('.modal-backdrop');
    // if (typeof modalBackDropDiv === 'undefined' || modalBackDropDiv == null) {
    //   let newDiv = document.createElement("div");
    //   newDiv.classList.add('modal-backdrop', 'show', 'fade');
    //   document.querySelector('body').appendChild(newDiv);

    //   let modalBackdropDiv = document.querySelector('.modal-backdrop');
    //   modalBackdropDiv.remove();

    //   document.querySelector('body').appendChild(newDiv);

    //   let htmlBody = document.querySelector('body');
    //   htmlBody.classList.remove('modal-open');
    //   // htmlBody.style.removeProperty('overflow');
    //   // htmlBody.style.removeProperty('padding-right');
    //   // htmlBody.style.removeProperty('opacity');
    // }
//   });
// }
  

//     // let MakeOrderModal = document.querySelector('#makeOrderModal');
//     // MakeOrderModal.style.display = 'block';
//     // MakeOrderModal.classList.add('show');
//     // MakeOrderModal.setAttribute('aria-modal', 'true');
//     // MakeOrderModal.setAttribute('aria-hidden', 'false');
//     // MakeOrderModal.setAttribute('role', 'dialog');

//     // let htmlBody = document.querySelector('body');
//     // htmlBody.classList.add('modal-open');
//     // htmlBody.style.overflow = 'hidden';
//     // htmlBody.style.paddingRight = '17px';
//     // htmlBody.style.opacity = 1;

//     //   document.querySelector('#product-link').value = ''; 
//     // document.querySelector('#product-name').value = ''; 
//     // document.querySelector('#product-price').value = ''; 
//     // document.querySelector('#product-size').value = ''; 
//     // document.querySelector('#delivery-price').value = ''; 
//     // document.querySelector('#product-color').value = ''; 
//     // document.querySelector('#product-comment').value = ''; 
//     // document.querySelector('#product-qty').value = ''; 
//     // document.querySelector('#photoreport').checked = true; 
//   })
// }

// let fuckBtn = document.querySelector('#fuck');
// fuckBtn.addEventListener('click', function() {
//   console.log(this);
// });


let addGoodBtn = document.querySelector('#add-good-btn');
let goodsList = document.querySelector('#goods-list');

if (addGoodBtn) {
  addGoodBtn.addEventListener('click', function(event){
  
    event.preventDefault();
    let link = document.querySelector('#product-link').value; 
    let name = document.querySelector('#product-name').value; 
    let price = document.querySelector('#product-price').value; 
    let size = document.querySelector('#product-size').value; 
    let delivery_cost = document.querySelector('#delivery-price').value; 
    let colour = document.querySelector('#product-color').value; 
    let comment = document.querySelector('#product-comment').value; 
    let quantity = document.querySelector('#product-qty').value; 
    let photos = document.querySelector('input[name="files[]"').files; 
    let photoreport = document.querySelector('#photoreport').checked; 

    if (photoreport) {
      var photoreportValue = 1;
    } else {
      var photoreportValue = 0;
    } 
    // console.log(link, name, price, size, delivery_cost, colour, comment, quantity, photoreport);

    var form_data = new FormData();
    for (let i=0; i < photos.length; i++) {
      form_data.append('file[]', photos[i]);
    }
    form_data.append('link', link);
    form_data.append('name', name);
    form_data.append('price', price);
    form_data.append('size', size);
    form_data.append('delivery_cost', delivery_cost);
    form_data.append('colour', colour);
    form_data.append('comment', comment);
    form_data.append('quantity', quantity);
    form_data.append('photoreport', photoreportValue);

    console.log(form_data);

    // dataToSend = {
    //     link: link,
    //     name: name,
    //     price: price,
    //     size: size,
    //     delivery_cost: delivery_cost,
    //     colour: colour,
    //     comment: comment,
    //     quantity: quantity,
    //     photos: form_data,
    //     photoreport: photoreport
    // }
    console.log(form_data);

    $.ajax( {
      url: '/order/ajax/ajax_add_good.php',
      method: 'POST',
      dataType: 'html',
      data: form_data,
      processData: false,
      contentType: false,
      success: function(data) {
        console.log(data);
        if (data == 'INVALID_FILE_SIZE'){  // уведомление о том, что превышен размер файла
          // event.preventDefault();
          alert('Размер фото превышает допустимый');
        } else if (data =='INVALID_FILE_TYPE'){  // уведомление о том, что не тот тип файла (не картинка)
          // event.preventDefault();
          alert('Загружаемый файл должен быть изображением');  
        } else if (data == 'NO_PHOTO_ADDED') {  // уведомление о том, что файл не загружен
          // event.preventDefault();
          alert('Вы не загрузили фото');
        } else if (data == 'SOMETHING_WENT_WRONG') {  // уведомление о том, что что-то пошло не так по какой-то другой причине, не перечисленной выше
          // event.preventDefault();
          alert('Что-то пошло не так. Попробуйте снова или загрузите другой файл');
        } else {
          let buttonsToClear = document.querySelectorAll('.delete-after-add-goods');
          for (let i = 0; i < buttonsToClear.length; i++) {
            buttonsToClear[i].remove();
          }
          data = JSON.parse(data);
          console.log(data['goods_string']);
          // console.log(data['buttons_string']);
          goodsList.innerHTML = data['goods_string'];

          if (typeof data['buttons_string'] !== 'undefined' && data['buttons_string'] != null && data['buttons_string'] != '') {
            goodsList.insertAdjacentHTML( 'afterEnd', data['buttons_string']);
            // goodsList.innerHTML += data['buttons_string'];
          }

          // event.target.click();
          link = ''; 
          name = ''; 
          price = '';
          size = '';
          delivery_cost = ''; 
          colour = ''; 
          link = ''; 
          comment = ''; 
          quantity = ''; 
          photoreport = true;
          document.querySelector('input[name="files[]"').value = '';
        }
        location.reload();
      }
    });

    // // var formdata = new FormData();
    // // var filedata = document.querySelector("#product-photo");
    // // console.log(filedata.prop('files'));
    // // var i = 0, len = filedata.files.length, file;
    // // for (; i < len; i++) {
    // //     file = filedata.files[i];
    // //     formdata.append("file", file);
    // // }
    // // console.log(formdata);
    // // $('#upload').on('click', function() {
      
    //   var form_data = new FormData();
    //   for (let i=0; i < photos.length; i++) {
    //     form_data.append('file[]', photos[i]);
    //   }
      
    //   for (var key of form_data.entries()) {
    //     console.log(key[0] + ', ' + key[1]);
    //   }
                
      
    //   console.log(form_data);  //Выводим инфо по файлам которые будут отправлены на сервер              

    //   $.ajax( {
    //     url: '/order/ajax/ajax_add_photos.php',
    //     type: 'POST',
    //     dataType: 'text', 
    //     data: form_data,
    //     processData: false,
    //     contentType: false,
    //     // enctype: 'multipart/form-data',
    //     success: function(data) {
    //       console.log(JSON.parse(data));
    //       // обрабатываем возможные ошибки, останавливаем отправку формы и выводим сообщения об ошибках
    //       if (data == 'INVALID_FILE_SIZE'){  // уведомление о том, что превышен размер файла
    //         // event.preventDefault();
    //         alert('Размер фото превышает допустимый');
    //       } else if (data =='INVALID_FILE_TYPE'){  // уведомление о том, что не тот тип файла (не картинка)
    //         // event.preventDefault();
    //         alert('Загружаемый файл должен быть изображением');  
    //       } else if (data == 'NO_PHOTO_ADDED') {  // уведомление о том, что файл не загружен
    //         // event.preventDefault();
    //         alert('Вы не загрузили фото');
    //       } else if (data == 'SOMETHING_WENT_WRONG') {  // уведомление о том, что что-то пошло не так по какой-то другой причине, не перечисленной выше
    //         // event.preventDefault();
    //         alert('Что-то пошло не так. Попробуйте снова или загрузите другой файл');
    //       }
    //     }
    //   });
    // // }); 

    // let MakeOrderModal = document.querySelector('#makeOrderModal');
    // MakeOrderModal.style.display = 'none';
    // MakeOrderModal.classList.remove('show');
    // MakeOrderModal.setAttribute('aria-modal', 'false');
    // MakeOrderModal.setAttribute('aria-hidden', 'true');
    // MakeOrderModal.removeAttribute('role');

    // let htmlBody = document.querySelector('body');
    // htmlBody.classList.remove('modal-open');
    // htmlBody.style.removeProperty('overflow');
    // htmlBody.style.removeProperty('padding-right');
    // htmlBody.style.removeProperty('opacity');

    // link = ''; 
    // name = ''; 
    // price = '';
    // size = '';
    // delivery_cost = ''; 
    // colour = ''; 
    // link = ''; 
    // comment = ''; 
    // quantity = ''; 
    // photoreport = true;

    // let modalBackdropDiv = document.querySelector('.modal-backdrop');
    // modalBackdropDiv.remove();
    // modalBackdropDiv.classList.remove('show');

    let instructionsBeforeGoods = document.querySelector('.mo-instructions');
    if (instructionsBeforeGoods)
      instructionsBeforeGoods.style.display = 'none'; 
  });

  
}



// поля модального окна для ввода параметров
let productPriceInput = document.querySelector('#product-price');
let productQuantityInput = document.querySelector('#product-qty');
let deliveryPriceInput = document.querySelector('#delivery-price');
let photoreport = document.querySelector('#photoreport');

let minus = document.querySelector('#minus-calc-btn');
let plus = document.querySelector('#plus-calc-btn');

let productCost = document.querySelector('#product-cost-calc');
let deliveryCost = document.querySelector('#delivery-cost-calc');
let servicesCost = document.querySelector('#services-cost-calc');
let totalCost = document.querySelector('#total-cost-calc');

if (productPriceInput) {
  productPriceInput.addEventListener('keyup', function() {
    productCost.innerHTML = productPriceInput.value * productQuantityInput.value;
    totalCost.innerHTML = parseFloat(productCost.innerHTML) + parseFloat(deliveryCost.innerHTML) + parseFloat(servicesCost.innerHTML);
  })
}

if (plus) {
  plus.addEventListener('click', function() {
    productCost.innerHTML = productPriceInput.value * productQuantityInput.value;
    totalCost.innerHTML = parseFloat(productCost.innerHTML) + parseFloat(deliveryCost.innerHTML) + parseFloat(servicesCost.innerHTML);
  })
}

if (minus) {
  minus.addEventListener('click', function() {
    productCost.innerHTML = productPriceInput.value * productQuantityInput.value;
    totalCost.innerHTML = parseFloat(productCost.innerHTML) + parseFloat(deliveryCost.innerHTML) + parseFloat(servicesCost.innerHTML);
  })
}

if (productQuantityInput) {
  productQuantityInput.addEventListener('keyup', function() {
    console.log(productQuantityInput);
    productCost.innerHTML = productPriceInput.value * productQuantityInput.value;
    totalCost.innerHTML = parseFloat(productCost.innerHTML) + parseFloat(deliveryCost.innerHTML) + parseFloat(servicesCost.innerHTML);
  })
}

if (deliveryPriceInput) {
  deliveryPriceInput.addEventListener('keyup', function() {
    deliveryCost.innerHTML = deliveryPriceInput.value;
    totalCost.innerHTML = parseFloat(productCost.innerHTML) + parseFloat(deliveryCost.innerHTML) + parseFloat(servicesCost.innerHTML);
  })
}

if (photoreport) {
  photoreport.addEventListener('change', function(event) {
    if (event.currentTarget.checked) {
      servicesCost.innerHTML = 5;
    } else {
      servicesCost.innerHTML = 0;
    }
    totalCost.innerHTML = parseFloat(productCost.innerHTML) + parseFloat(deliveryCost.innerHTML) + parseFloat(servicesCost.innerHTML);
  })
}


// данные товара в списке товаров на странице заказа (шаг 1)
let productQuantityInputList = document.querySelectorAll('.product-qty-list');
let minusList = document.querySelectorAll('.minus-cost-calc-list');
let plusList = document.querySelectorAll('.plus-cost-calc-list');

let deliveryCostYuanList = document.querySelectorAll('.delivery-cost-yuan-list');
let deliveryCostRubList = document.querySelectorAll('.delivery-cost-rub-list');
let servicesCostYuanList = document.querySelectorAll('.services-cost-yuan-list');
let servicesCostRubList = document.querySelectorAll('.services-cost-rub-list');

let productCostYuanList = document.querySelectorAll('.product-cost-yuan-list');
let productCostRubList = document.querySelectorAll('.product-cost-rub-list');
let totalCostYuanListNone = document.querySelectorAll('.total-cost-yuan-list-none');
let totalCostRubListNone = document.querySelectorAll('.total-cost-rub-list-none');
let totalCostYuanList = document.querySelectorAll('.total-cost-yuan-list');
let totalCostRubList = document.querySelectorAll('.total-cost-rub-list');

let allTotalCost = document.querySelector('#total-with-commission-cost');

if (minusList.length) {
  for (let i = 0; i < minusList.length; i++) {
    minusList[i].addEventListener('click', function() {
    
      let price = parseFloat(this.dataset.price);
      let rate = parseFloat(this.dataset.rate);
      productCostYuanList[i].innerHTML = (price * productQuantityInputList[i].value).toFixed(2);
      productCostRubList[i].innerHTML = '₽ ' + (price * productQuantityInputList[i].value * rate).toFixed(2);
      totalCostYuanListNone[i].innerHTML = '¥ ' +  (parseFloat(productCostYuanList[i].innerHTML.replace(/\s/g, "")) + parseFloat(deliveryCostYuanList[i].innerHTML.replace(/\s/g, "").slice(1)) + parseFloat(servicesCostYuanList[i].innerHTML.replace(/\s/g, "").slice(1))).toFixed(2);
      totalCostRubListNone[i].innerHTML = '( ₽ ' +  (parseFloat(productCostRubList[i].innerHTML.replace(/\s/g, "").slice(1)) + parseFloat(deliveryCostRubList[i].innerHTML.replace(/\s/g, "").slice(1)) + parseFloat(servicesCostRubList[i].innerHTML.replace(/\s/g, "").slice(1))).toFixed(2) + ' )';
      totalCostYuanList[i].innerHTML = '¥ ' + (parseFloat(productCostYuanList[i].innerHTML.replace(/\s/g, "")) + parseFloat(deliveryCostYuanList[i].innerHTML.replace(/\s/g, "").slice(1)) + parseFloat(servicesCostYuanList[i].innerHTML.replace(/\s/g, "").slice(1))).toFixed(2);
      totalCostRubList[i].innerHTML = '₽ ' + (parseFloat(productCostRubList[i].innerHTML.replace(/\s/g, "").slice(1)) + parseFloat(deliveryCostRubList[i].innerHTML.replace(/\s/g, "").slice(1)) + parseFloat(servicesCostRubList[i].innerHTML.replace(/\s/g, "").slice(1))).toFixed(2);
    
      let sum = 0;
      for (let j = 0; j < minusList.length; j++) {
        sum += parseFloat(totalCostRubList[j].innerHTML.replace(/\s/g, "").slice(1));
      }
  
      allTotalCost.innerHTML = 'Итого с учётом комисии: ' + sum.toFixed(2).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ') + ' ₽  ';

      dataToSend = {
        'quantity': productQuantityInputList[i].value,
        'link': this.closest('.mo-order').querySelector('a').href
      };

      $.ajax( {
        url: '/order/ajax/ajax_edit_quantity.php',
        method: 'POST',
        dataType: 'html',
        data: dataToSend,
        success: function(data) {
          console.log(data);
        }
      });
    })
    plusList[i].addEventListener('click', function() {
    
      let price = parseFloat(this.dataset.price);
      let rate = parseFloat(this.dataset.rate);
    
      console.log(productCostYuanList[i].innerHTML.replace(/\s/g, ""));
      // console.log(deliveryCostYuanList[i].innerHTML.replace(/\s/g, "").slice(1));
      console.log(deliveryCostYuanList[i].innerHTML.replace(/\s/g, ""));
      console.log(servicesCostYuanList[i].innerHTML.replace(/\s/g, "").slice(1));
    
      productCostYuanList[i].innerHTML = (price * productQuantityInputList[i].value).toFixed(2);
      productCostRubList[i].innerHTML = '₽ ' + (price * productQuantityInputList[i].value * rate).toFixed(2);
      totalCostYuanListNone[i].innerHTML = '¥ ' +  (parseFloat(productCostYuanList[i].innerHTML.replace(/\s/g, "")) + parseFloat(deliveryCostYuanList[i].innerHTML.replace(/\s/g, "")) + parseFloat(servicesCostYuanList[i].innerHTML.replace(/\s/g, "").slice(1))).toFixed(2);
      totalCostRubListNone[i].innerHTML = '( ₽ ' +  (parseFloat(productCostRubList[i].innerHTML.replace(/\s/g, "").replace(/\s/g, "").slice(1)) + parseFloat(deliveryCostYuanList[i].innerHTML.replace(/\s/g, "")) + parseFloat(servicesCostYuanList[i].innerHTML.replace(/\s/g, "").slice(1))).toFixed(2) + ')';
      totalCostYuanList[i].innerHTML = '¥ ' + (parseFloat(productCostYuanList[i].innerHTML) + parseFloat(deliveryCostYuanList[i].innerHTML.replace(/\s/g, "")) + parseFloat(servicesCostYuanList[i].innerHTML.replace(/\s/g, "").slice(1))).toFixed(2);
      totalCostRubList[i].innerHTML = '₽ ' + (parseFloat(productCostRubList[i].innerHTML.replace(/\s/g, "").slice(1)) + parseFloat(deliveryCostRubList[i].innerHTML.replace(/\s/g, "").slice(1)) + parseFloat(servicesCostRubList[i].innerHTML.replace(/\s/g, "").slice(1))).toFixed(2);
    
      let sum = 0;
      for (let j = 0; j < minusList.length; j++) {
        sum += parseFloat(totalCostRubList[j].innerHTML.replace(/\s/g, "").slice(1));
      }
  
      allTotalCost.innerHTML = 'Итого с учётом комисии: ' + sum.toFixed(2).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ') + ' ₽  ';

      dataToSend = {
        'quantity': productQuantityInputList[i].value,
        'link': this.closest('.mo-order').querySelector('a').href
      };

      $.ajax( {
        url: '/order/ajax/ajax_edit_quantity.php',
        method: 'POST',
        dataType: 'html',
        data: dataToSend,
        success: function(data) {
          console.log(data);
        }
      });
    })
  }
}



var btnWasClicked = false;

let askForBillBtns = document.querySelectorAll('.add-good-mobile');
// console.log(addGoodMobileBtn);
for (let i = 0; i < askForBillBtns.length; i++) {
  askForBillBtns[i].addEventListener('click', function(){
    let id = this.dataset.id;  // получение id заказа, по которому просят счёт
  
    if (!btnWasClicked) {
      // если нажимают первый раз, то открываем окно с чатом и выводим приветственное сообщение
      jivo_api.showProactiveInvitation(`Здравствуйте!
      Если у вас есть вопросы по заказу, смело задавайте! 😉
      Если вы хотите запросить счёт по заказу, напишите об этом или нажмите соответствующую кнопку в чате. Если вы хотите запросить счета сразу по нескольким заказам, укажите, пожалуйста, номера заказов (их можно посмотреть в списке заказов в своём профиле)
      `);
      btnWasClicked = true;
    } else {  // если нажимают уже не первый раз, то открываем окно без нового сообщения с привествием
      jivo_api.showProactiveInvitation(`
      Если вы хотите запросить счёт по заказу, напишите об этом или нажмите соответствующую кнопку в чате. Если вы хотите запросить счета сразу по нескольким заказам, укажите, пожалуйста, номера заказов (их можно посмотреть в списке заказов в своём профиле)
      `);
    }
   
  
    // передадим менеджеру в панели Jivo информацию об id заказа, для которого клиент просит счёт
    jivo_api.setCustomData([
      {
          "content": "ID заказа: " + id,
      },
    ]);
    jivo_api.open();
  });
}
