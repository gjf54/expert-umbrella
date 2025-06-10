function unban_user(url, id) {

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    
    $.ajax({
        url: url,
        data: {
            'id': id,
        },
        type: "POST",
        success: function(response) {
            return window.location.replace('/dashboard/moderation/bans')
        },
        error: function (response) {
            console.log('Error synchronize data')
        },
    })
    
}

