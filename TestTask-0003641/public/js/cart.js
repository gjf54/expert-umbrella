$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
})

function add_amount(url) {
    $.ajax({
        url: url,
        type: 'POST',
        success: function(data) {
            if(data == 0) {
                return console.log('Unexpected error')
            }

            let element = JSON.parse(data)
            
            let amount_field = $('#' + element.product_id + '-amount')
            let price_field = $('#' + element.product_id + '-price')
            let total_price_field = $('#' + element.product_id + '-total-price')

            amount_field.text(element.amount)
            total_price_field.text(Math.round((Number(price_field.text()) * Number(element.amount) + Number.EPSILON) * 100) / 100)
            
        },
        error: function(data) {
            console.log('Cart error - data was not synchronized')
        },
    })
}

function rem_amount(url) {  
    $.ajax({
        url: url,
        type: 'POST',
        success: function (data) {
            if(data == 0) {
                return console.log('Unexpected error')
            }

            let element = JSON.parse(data)
            
            let amount_field = $('#' + element.product_id + '-amount')
            let price_field = $('#' + element.product_id + '-price')
            let total_price_field = $('#' + element.product_id + '-total-price')

            amount_field.text(element.amount)
            total_price_field.text(Math.round((Number(price_field.text()) * Number(element.amount) + Number.EPSILON) * 100) / 100)
        },
        error: function (data) {
            console.log('Cart error - data was not synchronized')
        },
    })
}

function rem_element(url) {  
    $.ajax({
        url: url,
        type: 'POST',
        success: function (data) {
            let element = JSON.parse(data)
            let product = $('#' + element.id)
            product.remove()

        },
        error: function (data) {
            console.log('Cart error - data was not synchronized')
        },
    })
}

function set_element(url, id) {
    $.ajax({
        url: url,
        type: 'POST',
        success: function (data) {
            
            if(data == 0) {
                return console.log('Something went wrong')
            }
            
            let btn = $('#add_to_cart')

            btn.text('В корзине');
            btn.attr('onclick', "window.location.replace('/cart')");
        },
        error: function (data) {
            console.log('Add product to cart error - data was not synchronized')
        },
    })
}
