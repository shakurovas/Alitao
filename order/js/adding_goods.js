// STEP 1

let isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent);


let addGoodBtn = document.querySelector('#add-good-btn');
let goodsList = document.querySelector('#goods-list');

let linkInput = document.querySelector('#product-link'); 
let nameInput = document.querySelector('#product-name'); 
let priceInput = document.querySelector('#product-price');
let delivery_costInput = document.querySelector('#delivery-price');

let addingGoodForm = document.querySelector('#adding-good-form');

if (isMobile) {
  var requiredFields = document.querySelector('#required-fields-mobile');
} else {
  var requiredFields = document.querySelector('#required-fields');
}


if (typeof addGoodBtn !== 'undefined' && addGoodBtn != null) {
  addGoodBtn.addEventListener('click', function() {
    let linkFieldValue = linkInput.value;
    let nameFieldValue = nameInput.value;
    let priceFieldValue = priceInput.value;
    let delivery_costFieldValue = delivery_costInput.value;

    if (delivery_costFieldValue == '' || priceFieldValue == '' || linkFieldValue == '' || nameFieldValue == '') {
      
      if (typeof requiredFields !== 'undefined' && requiredFields != null) {
        requiredFields.style.display = 'block';
        addGoodBtn.disabled = true;
      }
    } else {
      if (typeof requiredFields !== 'undefined' && requiredFields != null) {
        requiredFields.style.display = 'none';
        addGoodBtn.disabled = false;
      }
    }
  });
}


if (typeof linkInput !== 'undefined' && linkInput != null && typeof nameInput !== 'undefined' && nameInput != null && typeof priceInput !== 'undefined' && priceInput != null && typeof delivery_costInput !== 'undefined' && delivery_costInput != null) {
  let linkField = linkInput.value;
  let nameField = nameInput.value;
  let priceField = priceInput.value;
  let delivery_costField = delivery_costInput.value;

  if (!isMobile) {
    if (typeof addingGoodForm !== 'undefined' && typeof addingGoodForm != null) {
      addingGoodForm.addEventListener('keyup', function() {
        let linkFieldNew = document.querySelector('#product-link').value; 
        let nameFieldNew = document.querySelector('#product-name').value; 
        let priceFieldNew = document.querySelector('#product-price').value;
        let delivery_costFieldNew = document.querySelector('#delivery-price').value;
      
        if (delivery_costFieldNew == '' || priceFieldNew == '' || linkFieldNew == '' || nameFieldNew == '') {
          if (typeof requiredFields !== 'undefined' && requiredFields != null) {
            requiredFields.style.display = 'block';
            addGoodBtn.disabled = true;
          }
        } else {
          if (typeof requiredFields !== 'undefined' && requiredFields != null) {
            requiredFields.style.display = 'none';
            addGoodBtn.disabled = false;
          }
        }
      })
    }
  } else {
    document.querySelector('#product-link').addEventListener('keyup', function() {
  
      let linkFieldNew = document.querySelector('#product-link').value; 
      let nameFieldNew = document.querySelector('#product-name').value; 
      let priceFieldNew = document.querySelector('#product-price').value;
      let delivery_costFieldNew = document.querySelector('#delivery-price').value;
    
      if (delivery_costFieldNew == '' || priceFieldNew == '' || linkFieldNew == '' || nameFieldNew == '') {
        if (typeof requiredFields !== 'undefined' && requiredFields != null) {
          requiredFields.style.display = 'block';
          addGoodBtn.disabled = true;
        }
      } else {
        if (typeof requiredFields !== 'undefined' && requiredFields != null) {
          requiredFields.style.display = 'none';
          addGoodBtn.disabled = false;
        }
      }
    })
    
    document.querySelector('#product-name').addEventListener('keyup', function() {
      let linkFieldNew = document.querySelector('#product-link').value; 
      let nameFieldNew = document.querySelector('#product-name').value; 
      let priceFieldNew = document.querySelector('#product-price').value;
      let delivery_costFieldNew = document.querySelector('#delivery-price').value;
    
      if (delivery_costFieldNew == '' || priceFieldNew == '' || linkFieldNew == '' || nameFieldNew == '') {
        if (typeof requiredFields !== 'undefined' && requiredFields != null) {
          requiredFields.style.display = 'block';
          addGoodBtn.disabled = true;
        }
      } else {
        if (typeof requiredFields !== 'undefined' && requiredFields != null) {
          requiredFields.style.display = 'none';
          addGoodBtn.disabled = false;
        }
      }
    })
    
    document.querySelector('#product-price').addEventListener('keyup', function() {
      let linkFieldNew = document.querySelector('#product-link').value; 
      let nameFieldNew = document.querySelector('#product-name').value; 
      let priceFieldNew = document.querySelector('#product-price').value;
      let delivery_costFieldNew = document.querySelector('#delivery-price').value;
    
      if (delivery_costFieldNew == '' || priceFieldNew == '' || linkFieldNew == '' || nameFieldNew == '') {
        if (typeof requiredFields !== 'undefined' && requiredFields != null) {
          requiredFields.style.display = 'block';
          addGoodBtn.disabled = true;
        }
      } else {
        if (typeof requiredFields !== 'undefined' && requiredFields != null) {
          requiredFields.style.display = 'none';
          addGoodBtn.disabled = false;
        }
      }
    })
    
    document.querySelector('#delivery-price').addEventListener('keyup', function() {
      let linkFieldNew = document.querySelector('#product-link').value; 
      let nameFieldNew = document.querySelector('#product-name').value; 
      let priceFieldNew = document.querySelector('#product-price').value;
      let delivery_costFieldNew = document.querySelector('#delivery-price').value;
    
      if (delivery_costFieldNew == '' || priceFieldNew == '' || linkFieldNew == '' || nameFieldNew == '') {
        if (typeof requiredFields !== 'undefined' && requiredFields != null) {
          requiredFields.style.display = 'block';
          addGoodBtn.disabled = true;
        }
      } else {
        if (typeof requiredFields !== 'undefined' && requiredFields != null) {
          requiredFields.style.display = 'none';
          addGoodBtn.disabled = false;
        }
      }
    })  
  }  
}


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

    let isEditMode = document.querySelector('#is_edit_mode');
    let isEditModeValue = 0;

    if (typeof isEditMode.value === 'undefined' || isEditMode.value == null) isEditModeValue = false;
    else isEditModeValue = isEditMode.value;

    if (photoreport) {
      var photoreportValue = 1;
    } else {
      var photoreportValue = 0;
    }

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
    form_data.append('is_edit_mode', isEditModeValue);


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
          alert('Размер фото превышает допустимый');
        } else if (data =='INVALID_FILE_TYPE'){  // уведомление о том, что не тот тип файла (не картинка)
          alert('Загружаемый файл должен быть изображением');  
        } else if (data == 'NO_PHOTO_ADDED') {  // уведомление о том, что файл не загружен
          alert('Вы не загрузили фото');
        } else if (data == 'SOMETHING_WENT_WRONG') {  // уведомление о том, что что-то пошло не так по какой-то другой причине, не перечисленной выше
          alert('Что-то пошло не так. Попробуйте снова или загрузите другой файл');
        } else {
          let buttonsToClear = document.querySelectorAll('.delete-after-add-goods');
          for (let i = 0; i < buttonsToClear.length; i++) {
            buttonsToClear[i].remove();
          }
          data = JSON.parse(data);
          console.log(data['goods_string']);
          if (!isMobile) {
            if (typeof data['goods_string'] !== 'undefined' && data['goods_string'] != null && data['goods_string'] != '') {
              goodsList.innerHTML = data['goods_string'];
            }
  
            if (typeof data['buttons_string'] !== 'undefined' && data['buttons_string'] != null && data['buttons_string'] != '') {
              goodsList.insertAdjacentHTML( 'afterEnd', data['buttons_string']);
            }
          }
         
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
          document.querySelector('.products-photo-grid').innerHTML = '';
        }
        if (isMobile) {
          if (isEditModeValue != 0)
            window.location.href = '/order/make_order_step_1.php?edit=y';
          else {
            window.location.href = '/order/make_order_step_1.php';
          }
        } else {
          location.reload();
        }
      }
    });

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
    productCost.innerHTML = (productPriceInput.value * productQuantityInput.value).toFixed(2);
    totalCost.innerHTML = (parseFloat(productCost.innerHTML) + parseFloat(deliveryCost.innerHTML) + parseFloat(servicesCost.innerHTML)).toFixed(2);
  })
}

if (plus) {
  plus.addEventListener('click', function() {
    productCost.innerHTML = (productPriceInput.value * productQuantityInput.value).toFixed(2);
    if (photoreport.checked) {
      servicesCost.innerHTML = (5 * parseFloat(productQuantityInput.value)).toFixed(2);
    } else {
      servicesCost.innerHTML = Number(0.00).toFixed(2);
    }
    totalCost.innerHTML = (parseFloat(productCost.innerHTML) + parseFloat(deliveryCost.innerHTML) + parseFloat(servicesCost.innerHTML)).toFixed(2);
  })
}

if (minus) {
  minus.addEventListener('click', function() {
    productCost.innerHTML = (productPriceInput.value * productQuantityInput.value).toFixed(2);
    if (photoreport.checked) {
      servicesCost.innerHTML = (5 * parseFloat(productQuantityInput.value)).toFixed(2);
    } else {
      servicesCost.innerHTML = Number(0.00).toFixed(2);
    }
    totalCost.innerHTML = (parseFloat(productCost.innerHTML) + parseFloat(deliveryCost.innerHTML) + parseFloat(servicesCost.innerHTML)).toFixed(2);
  })
}

if (productQuantityInput) {
  productQuantityInput.addEventListener('keyup', function() {
    productCost.innerHTML = (productPriceInput.value * productQuantityInput.value).toFixed(2);
    if (photoreport.checked) {
      servicesCost.innerHTML = (5 * parseFloat(productQuantityInput.value)).toFixed(2);
    } else {
      servicesCost.innerHTML = Number(0.00).toFixed(2);
    }
    totalCost.innerHTML = (parseFloat(productCost.innerHTML) + parseFloat(deliveryCost.innerHTML) + parseFloat(servicesCost.innerHTML)).toFixed(2);
  })
}

if (deliveryPriceInput) {
  deliveryPriceInput.addEventListener('keyup', function() {
    deliveryCost.innerHTML = (parseFloat(deliveryPriceInput.value)).toFixed(2);
    totalCost.innerHTML = (parseFloat(productCost.innerHTML) + parseFloat(deliveryCost.innerHTML) + parseFloat(servicesCost.innerHTML)).toFixed(2);
  })
}

if (photoreport) {
  photoreport.addEventListener('change', function(event) {
    if (event.currentTarget.checked) {
      servicesCost.innerHTML = (5 * parseFloat(productQuantityInput.value)).toFixed(2);
    } else {
      servicesCost.innerHTML = Number(0.00).toFixed(2);
    }
    totalCost.innerHTML = (parseFloat(productCost.innerHTML) + parseFloat(deliveryCost.innerHTML) + parseFloat(servicesCost.innerHTML)).toFixed(2);
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

let isEditMode = document.querySelector('#is_edit_mode');

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
      let sumYuan = 0;
      for (let j = 0; j < minusList.length; j++) {
        sum += parseFloat(totalCostRubList[j].innerHTML.replace(/\s/g, "").slice(1));
        sumYuan += parseFloat(totalCostYuanList[j].innerHTML.replace(/\s/g, "").slice(1));
      }

      if (sumYuan <= 5000) {
        sum *= 1.05;
      } else {
        sum *= 1.03;
      }
  
      allTotalCost.innerHTML = 'Итого с учётом комисии: ' + sum.toFixed(2).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ') + ' ₽  ';

      if (typeof isEditMode.value === 'undefined' || isEditMode.value == null) var isEditModeValue = false;
      else var isEditModeValue = isEditMode.value;

      dataToSend = {
        'quantity': productQuantityInputList[i].value,
        'link': this.closest('.mo-order').querySelector('a').href,
        'is_edit_mode': isEditModeValue,
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
    
      productCostYuanList[i].innerHTML = (price * productQuantityInputList[i].value).toFixed(2);
      productCostRubList[i].innerHTML = '₽ ' + (price * productQuantityInputList[i].value * rate).toFixed(2);
      totalCostYuanListNone[i].innerHTML = '¥ ' +  (parseFloat(productCostYuanList[i].innerHTML.replace(/\s/g, "")) + parseFloat(deliveryCostYuanList[i].innerHTML.replace(/\s/g, "")) + parseFloat(servicesCostYuanList[i].innerHTML.replace(/\s/g, "").slice(1))).toFixed(2);
      totalCostRubListNone[i].innerHTML = '( ₽ ' +  (parseFloat(productCostRubList[i].innerHTML.replace(/\s/g, "").replace(/\s/g, "").slice(1)) + parseFloat(deliveryCostYuanList[i].innerHTML.replace(/\s/g, "")) + parseFloat(servicesCostYuanList[i].innerHTML.replace(/\s/g, "").slice(1))).toFixed(2) + ')';
      totalCostYuanList[i].innerHTML = '¥ ' + (parseFloat(productCostYuanList[i].innerHTML) + parseFloat(deliveryCostYuanList[i].innerHTML.replace(/\s/g, "")) + parseFloat(servicesCostYuanList[i].innerHTML.replace(/\s/g, "").slice(1))).toFixed(2);
      totalCostRubList[i].innerHTML = '₽ ' + (parseFloat(productCostRubList[i].innerHTML.replace(/\s/g, "").slice(1)) + parseFloat(deliveryCostRubList[i].innerHTML.replace(/\s/g, "").slice(1)) + parseFloat(servicesCostRubList[i].innerHTML.replace(/\s/g, "").slice(1))).toFixed(2);
    
      let sum = 0;
      let sumYuan = 0;
      for (let j = 0; j < minusList.length; j++) {
        sum += parseFloat(totalCostRubList[j].innerHTML.replace(/\s/g, "").slice(1));
        sumYuan += parseFloat(totalCostYuanList[j].innerHTML.replace(/\s/g, "").slice(1));
      }

      if (sumYuan <= 5000) {
        sum *= 1.05;
      } else {
        sum *= 1.03;
      }
  
      allTotalCost.innerHTML = 'Итого с учётом комисии: ' + sum.toFixed(2).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ') + ' ₽  ';
      
      if (typeof isEditMode.value === 'undefined' || isEditMode.value == null) var isEditModeValue = false;
      else var isEditModeValue = isEditMode.value;

      dataToSend = {
        'quantity': productQuantityInputList[i].value,
        'link': this.closest('.mo-order').querySelector('a').href,
        'is_edit_mode': isEditModeValue
      };
      console.log(dataToSend);

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


let mobileAddGoodBeforeBtn = document.querySelector('.mobile-add-good-before');
if (typeof mobileAddGoodBeforeBtn !== 'undefined' && mobileAddGoodBeforeBtn != null) {
  mobileAddGoodBeforeBtn.addEventListener('click', function() {
    let mobileLinkValue = document.querySelector('#add-product-input').value;
    window.location.href = '/order/mobile_add_edit_order.php?link=' + mobileLinkValue;
  });
}


let addEditedGoodBtn = document.querySelector('#continue');
if (typeof addEditedGoodBtn !== 'undefined' && addEditedGoodBtn != null) {
  addEditedGoodBtn.addEventListener('click', function() {
    
  });
}


let closingAddingGoodModalBtn = document.querySelector('#close-adding-order-modal-btn');
if (typeof closingAddingGoodModalBtn !== undefined && closingAddingGoodModalBtn != null) {
  closingAddingGoodModalBtn.addEventListener('click', function() {
    document.getElementById("adding-good-form").reset();
    document.querySelector('#product-cost-calc').innerHTML = 0.00;
    document.querySelector('#delivery-cost-calc').innerHTML = 0.00;
    document.querySelector('#services-cost-calc').innerHTML = 5.00;
    document.querySelector('#total-cost-calc').innerHTML = 5.00;
    document.querySelector('input[name="files[]"').value = '';
    document.querySelector('.products-photo-grid').innerHTML = '';
  });
}