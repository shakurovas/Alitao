// STEP 1


// let addGoodsBtnCart = document.querySelectorAll('.add-goods-btn-cart');
// for (let i = 0; i < addGoodsBtnCart.length; i++) {
//   addGoodsBtnCart[i].addEventListener('click', function() {
//     let modalBackDropDiv = document.querySelector('.modal-backdrop');
//     if (typeof modalBackDropDiv === 'undefined' || modalBackDropDiv == null) {
//       let newDiv = document.createElement("div");
//       newDiv.classList.add('modal-backdrop', 'show', 'fade');
//       document.querySelector('body').appendChild(newDiv);

//       let modalBackdropDiv = document.querySelector('.modal-backdrop');
//       modalBackdropDiv.remove();

//       document.querySelector('body').appendChild(newDiv);

//       let htmlBody = document.querySelector('body');
//       htmlBody.classList.remove('modal-open');
//       // htmlBody.style.removeProperty('overflow');
//       // htmlBody.style.removeProperty('padding-right');
//       // htmlBody.style.removeProperty('opacity');
//     }

  

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


let addGoodBtn = document.querySelector('#add-good-btn');
let goodsList = document.querySelector('#goods-list');

if (addGoodBtn) {
  addGoodBtn.addEventListener('click', function(){
  
    let link = document.querySelector('#product-link').value; 
    let name = document.querySelector('#product-name').value; 
    let price = document.querySelector('#product-price').value; 
    let size = document.querySelector('#product-size').value; 
    let delivery_cost = document.querySelector('#delivery-price').value; 
    let colour = document.querySelector('#product-color').value; 
    let comment = document.querySelector('#product-comment').value; 
    let quantity = document.querySelector('#product-qty').value; 
    let photoreport = document.querySelector('#photoreport').checked; 
    // console.log(link, name, price, size, delivery_cost, colour, comment, quantity, photoreport);

    dataToSend = {
        link: link,
        name: name,
        price: price,
        size: size,
        delivery_cost: delivery_cost,
        colour: colour,
        comment: comment,
        quantity: quantity,
        photoreport: photoreport
    }
    console.log(dataToSend);

    $.ajax( {
      url: '/order/ajax/ajax_add_good.php',
      method: 'POST',
      dataType: 'html',
      data: dataToSend,
      success: function(data) {
        // console.log(data);
        data = JSON.parse(data);
        
        console.log(data['goods_string']);
        goodsList.innerHTML = data['goods_string'];
      }
    });

    let MakeOrderModal = document.querySelector('#makeOrderModal');
    MakeOrderModal.style.display = 'none';
    MakeOrderModal.classList.remove('show');
    MakeOrderModal.setAttribute('aria-modal', 'false');
    MakeOrderModal.setAttribute('aria-hidden', 'true');
    MakeOrderModal.removeAttribute('role');

    let htmlBody = document.querySelector('body');
    htmlBody.classList.remove('modal-open');
    htmlBody.style.removeProperty('overflow');
    htmlBody.style.removeProperty('padding-right');
    htmlBody.style.removeProperty('opacity');

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

    let modalBackdropDiv = document.querySelector('.modal-backdrop');
    modalBackdropDiv.remove();
    // modalBackdropDiv.classList.remove('show');

    let instructionsBeforeGoods = document.querySelector('.mo-instructions');
    if (instructionsBeforeGoods)
      instructionsBeforeGoods.style.dispay = 'none'; 
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
      // console.log(productCostYuanList.innerHTML.replace(/\s/g, ""));
      // console.log(productCostRubList.innerHTML.replace(/\s/g, "").replace(/\s/g, ""));
      // console.log(totalCostYuanListNone.innerHTML.replace(/\s/g, ""));
      // console.log(totalCostRubListNone.innerHTML.replace(/\s/g, ""));
      // console.log(totalCostYuanList.innerHTML.replace(/\s/g, ""));
      // console.log(totalCostRubList.innerHTML.replace(/\s/g, ""));
    
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
    })
    plusList[i].addEventListener('click', function() {
    
      let price = parseFloat(this.dataset.price);
      let rate = parseFloat(this.dataset.rate);
    
      console.log(productCostYuanList[i].innerHTML.replace(/\s/g, ""));
      console.log(deliveryCostYuanList[i].innerHTML.replace(/\s/g, "").slice(1));
      console.log(servicesCostYuanList[i].innerHTML.replace(/\s/g, "").slice(1));
    
      productCostYuanList[i].innerHTML = (price * productQuantityInputList[i].value).toFixed(2);
      productCostRubList[i].innerHTML = '₽ ' + (price * productQuantityInputList[i].value * rate).toFixed(2);
      totalCostYuanListNone[i].innerHTML = '¥ ' +  (parseFloat(productCostYuanList[i].innerHTML.replace(/\s/g, "")) + parseFloat(deliveryCostYuanList[i].innerHTML.replace(/\s/g, "")) + parseFloat(servicesCostYuanList[i].innerHTML.replace(/\s/g, "").slice(1))).toFixed(2);
      totalCostRubListNone[i].innerHTML = '( ₽ ' +  (parseFloat(productCostRubList[i].innerHTML.replace(/\s/g, "").replace(/\s/g, "").slice(1)) + parseFloat(deliveryCostYuanList[i].innerHTML.replace(/\s/g, "").slice(1)) + parseFloat(servicesCostYuanList[i].innerHTML.replace(/\s/g, "").slice(1))).toFixed(2) + ')';
      totalCostYuanList[i].innerHTML = '¥ ' + (parseFloat(productCostYuanList[i].innerHTML) + parseFloat(deliveryCostYuanList[i].innerHTML.replace(/\s/g, "")) + parseFloat(servicesCostYuanList[i].innerHTML.replace(/\s/g, "").slice(1))).toFixed(2);
      totalCostRubList[i].innerHTML = '₽ ' + (parseFloat(productCostRubList[i].innerHTML.replace(/\s/g, "").slice(1)) + parseFloat(deliveryCostRubList[i].innerHTML.replace(/\s/g, "").slice(1)) + parseFloat(servicesCostRubList[i].innerHTML.replace(/\s/g, "").slice(1))).toFixed(2);
    
      let sum = 0;
      for (let j = 0; j < minusList.length; j++) {
        sum += parseFloat(totalCostRubList[j].innerHTML.replace(/\s/g, "").slice(1));
      }
  
      allTotalCost.innerHTML = 'Итого с учётом комисии: ' + sum.toFixed(2).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ') + ' ₽  ';
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

