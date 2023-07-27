// STEP 3


let comment = document.querySelector('#comment').value;

let confirmOrderBtn = document.querySelector('#confirm-order-btn');
confirmOrderBtn.addEventListener('click', function() {
    if (comment) 
        dataToSend = {
            order_comment: comment,
        }
    else
        dataToSend = {
            order_comment: 'Нет комментария',
        }
    
    $.ajax( {
        url: '/order/ajax/ajax_create_order.php',
        method: 'POST',
        dataType: 'html',
        data: dataToSend,
        success: function(data) {
            console.log(data);
            window.location.replace('/order/my_orders.php');
        }
    });
});

