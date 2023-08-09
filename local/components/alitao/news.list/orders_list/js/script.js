let hideOrderButtons = document.querySelectorAll('.order-hide-btn');
console.log(hideOrderButtons);

for (let i = 0; i < hideOrderButtons.length; i++) {
    hideOrderButtons[i].addEventListener('click', function() {
        // console.log(this.dataset.id);
        $.ajax( {
          url: '/local/templates/alitao/components/bitrix/news/my_orders/bitrix/news.list/orders_list/ajax/ajax_hide_order.php',
          method: 'POST',
          dataType: 'html',
          data: {'id': this.dataset.id},
          success: function(data) {
            console.log(data);
            location.reload();
          }
        });
    });
}


let statusChoosing = document.querySelector('#status-choosing');
console.log(statusChoosing);
if (typeof statusChoosing !== 'undefined' && statusChoosing != null) {
  statusChoosing.addEventListener('DOMSubtreeModified', function() {
    console.log(statusChoosing.innerHTML);
    if (statusChoosing.innerHTML != '') {
      $.ajax( {
        url: '/local/templates/alitao/components/bitrix/news/my_orders/bitrix/news.list/orders_list/ajax/ajax_filter_status.php',
        method: 'POST',
        dataType: 'html',
        data: {'status': statusChoosing.innerHTML},
        success: function(data) {
          console.log(data);
          data = JSON.parse(data);
          let ordersListDiv = document.querySelector('.orders__list');
          ordersListDiv.innerHTML = data['orders_in_string']
          // location.reload();
        }
      });
    }
  })
}



let editOrderBtn = document.querySelectorAll('.order-edit-btn');
// console.log(editOrderBtn);
for (let i = 0; i < editOrderBtn.length; i++) {
  editOrderBtn[i].addEventListener('click', function() {
    $.ajax( {
      url: '/local/templates/alitao/components/bitrix/news/my_orders/bitrix/news.list/orders_list/ajax/ajax_add_order_to_edit.php',
      method: 'POST',
      dataType: 'html',
      data: {
        'order_content': this.dataset.content,
        'order_id': this.dataset.id,
        'is_insured': this.dataset.insurance,
        'comment': this.dataset.comment,
        'delivery': this.dataset.delivery
      },
      success: function(data) {
        console.log(data);
      }
    });
    window.location.href = '/order/make_order_step_1.php?edit=y&order_id=' + this.dataset.id + '&order_content=' + this.dataset.content;
  });
  
}