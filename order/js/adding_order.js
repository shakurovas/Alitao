// STEP 3


let comment = document.querySelector('#comment');
var commentText = '';
comment.addEventListener('change', function(){
    commentText = this.value;

});
let confirmOrderBtn = document.querySelector('#confirm-order-btn');
confirmOrderBtn.addEventListener('click', function(event) {
    event.preventDefault();
    if (commentText != '') 
        dataToSend = {
            order_comment: commentText,
        }
    else
        dataToSend = {
            order_comment: 'нет комментария',
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

