function delete_token(id) {
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $.ajax({
        type: "POST",
        data: {
            token_id: id,
        },
        url: delete_token_url,
        success: function (response) {            
            let token = $("#token-" + id)
            token.remove();
            return
        },
        error: function (response) {
            if(response.status == 401) {
                window.location.replace('/login')
            }
            console.log('Token service error - data was not synchronized');
        }
    });
}