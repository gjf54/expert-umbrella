$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
})

function add_amount(url) {
    $.ajax({
        url: url,
        type: 'POST',
        success: function(data) {
            let element = JSON.parse(data)
            let amount_field = $('#amount-' + element.product_id)
            let product_amount = $('#price-product-' + element.id + ' span[role="product_amount"]')
            let price_result = $('#price-product-' + element.id + ' span[role="price_result"]')
            let real_price = $('#price-product-' + element.id + ' span[role="price_real"]')

            amount_field.text(element.amount)
            product_amount.text(element.amount)
            price_result.text(Number(real_price.text()) * Number(element.amount))
            
        },
        error: function(data) {
            console.log('Shopping cart error - data was not synchronized')
        },
    })
}

function rem_amount(url) {  
    $.ajax({
        url: url,
        type: 'POST',
        success: function (data) {
            if(data == 0){
                return
            }
            let element = JSON.parse(data)
            let amount_field = $('#amount-' + element.product_id)
            let product_amount = $('#price-product-' + element.id + '>span[role="product_amount"]')
            let price_result = $('#price-product-' + element.id + '>span[role="price_result"]')
            let real_price = $('#price-product-' + element.id + '>span[role="price_real"]')

            amount_field.text(element.amount)
            product_amount.text(element.amount)
            price_result.text(Number(real_price.text()) * Number(element.amount))
        },
        error: function (data) {
            console.log('Shopping cart error - data was not synchronized')
        },
    })
}

function rem_element(url) {  
    $.ajax({
        url: url,
        type: 'POST',
        success: function (data) {
            let response = JSON.parse(data)
            let product = $('#element-' + response.id)
            product.remove()

            let products = $('.product')
            let button = $('#order_button')

            if(products.length == 0) {
                button.remove()
                let orders = $('.products')
                let empty = $('.empty_products')
                orders.addClass('void_products')
                empty.css('display', 'flex')
            }
        },
        error: function (data) {
            console.log('Shopping cart error - data was not synchronized')
        },
    })
}

function set_element(url) {
    $.ajax({
        url: url,
        type: 'POST',
        success: function (data) {
            let response = JSON.parse(data)
            let btn = $('#product-' + response.id_prod)
            let controllers = $('#control-' + response.id_prod)
            let succes_field = $('#success-' + response.id_prod)

            btn.css('display', 'none')
            controllers.css('display', 'flex !important')
        },
        error: function (data) {
            console.log('Add product to cart error - data was not synchronized')
        },
    })
}

function confirm_order(){
    let black_block = $('.black_block')
    let confirm_window = $('.confirmation_window')
    let products = $('.products')
    const y = (document.documentElement.scrollHeight / 2) + 'px'

    products.css('opacity', '0.2')
    console.log(y)
    confirm_window.css('display', 'flex')
    confirm_window.css('margin-top', y)

    let confirm_button = $('#confirm_button')
    let unconfirm_button = $('#unconfirm_button')

    confirm_button.click(function (e) { 
        black_block.css('display', 'none')
        confirm_window.css('display', 'none')

        $.ajax({
            url: order_url,
            type: 'POST',
            success(response) {
                window.location.replace("/profile")
            },
            error(response) {
                console.log('Order error - data was not synchronized')
            },
        })
    })

    unconfirm_button.click(function (e) { 
        products.css('opacity', '1')
        confirm_window.css('display', 'none')
    });
}
