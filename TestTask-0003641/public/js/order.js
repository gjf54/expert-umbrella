$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
})

function end_order(url) {
    $.ajax({
        url: url,
        data: {
            id: Number(order),
        },
        type: 'POST',
        success: function(data) {
            if(data == 0) {
                return console.log('Unexpected error')
            }

            var status = JSON.parse(data)
            
            var status_field = $('#status')
            var block = $('#end_order_section')

            status_field.text(status)
            block.remove()
        },
        error: function(data) {
            console.log('Order error - data was not synchronized')
        },
    })
}
