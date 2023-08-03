// STEP 2

let full_name = document.querySelector('#fio'); 
let region = document.querySelector('#region'); 
let city = document.querySelector('#city'); 
let address = document.querySelector('#address'); 
let zipindex = document.querySelector('#zipindex'); 
let phone = document.querySelector('#phone'); 
let email = document.querySelector('#email'); 
let typedelivery1 = document.querySelector('#typedelivery-1'); 
let typedelivery2 = document.querySelector('#typedelivery-2');
let typedelivery3 = document.querySelector('#typedelivery-3');
let insurance_included = document.querySelector('#insurance');

var inputFields = [full_name, region, city, address, zipindex, phone, email];

let redLine = document.querySelector('#all-fields-are-required');

for (let i = 0; i < inputFields.length; i++) {
    if (inputFields[i].value) {
        inputFields[i].style.background = 'rgba(68,153,29,.5)';
        inputFields[i].classList.remove('error');
        inputFields[i].classList.toggle('success');
    } else {
        inputFields[i].style.background = 'rgba(216,37,0,.5)';
        inputFields[i].classList.remove('sucess');
        inputFields[i].classList.toggle('error');
    }
    inputFields[i].addEventListener('keyup', function() {
        if (inputFields[i].value) {
            inputFields[i].style.background = 'rgba(68,153,29,.5)';
            inputFields[i].classList.remove('error');
            inputFields[i].classList.toggle('success');
        } else {
            inputFields[i].style.background = 'rgba(216,37,0,.5)';
            inputFields[i].classList.remove('sucess');
            inputFields[i].classList.toggle('error');
        }
    })
}

let continueBtnStep2 = document.querySelector('#continue-step-2');
continueBtnStep2.addEventListener('click', function(event) {
    event.preventDefault();
    
    if (typedelivery1.checked) var delivery_type = 'Быстрая авиа'
    else if (typedelivery2.checked) var delivery_type = 'Быстрая авто';
    else if (typedelivery3.checked) var delivery_type = 'Авто';

    if (insurance_included.checked) {
        var insuranceIncludedValue = 1;
      } else {
        var insuranceIncludedValue = 0;
    } 

    if (full_name.value && region.value && city.value && address.value && zipindex.value && phone.value && email.value && delivery_type) {
        dataToSend = {
            full_name: full_name.value,
            region: region.value,
            city: city.value,
            address: address.value,
            zipindex: zipindex.value,
            phone: phone.value,
            email: email.value,
            delivery_type: delivery_type,
            insurance_included: insuranceIncludedValue
        }
        
        $.ajax( {
            url: '/order/ajax/ajax_add_user_info.php',
            method: 'POST',
            dataType: 'html',
            data: dataToSend,
            success: function(data) {
                console.log(data);
                window.location.href = '/order/make_order_step_3.php';
            }
        });
        redLine.style.display = 'none';
    } else {
        for (let i = 0; i < inputFields.length; i++) {
            if (inputFields[i].value == '') {
                inputFields[i].classList.toggle('error');
                inputFields[i].style.background = 'rgba(216,37,0,.5)';
            } else {
                inputFields[i].classList.toggle('success');
                inputFields[i].style.background = 'rgba(68,153,29,.5)';
            }
        }
        redLine.style.display = 'block';
    }
});
