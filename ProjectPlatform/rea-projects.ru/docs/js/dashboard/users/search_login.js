$input = $('.typeahead')

$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
})

$.ajax({
    url: "/data/get_logins",
    type: "POST",
    success: function(logins) {
        input.typeahead({
            source: logins,
            autoSelect: true,
        })
    },
    error: function () {
        console.log('error fetch data - logins')
    },
})

$input.change(function () {
    var current = $input.typeahead("getActive")
    matches = []

    if(current) {
        if(current.name = $input.val) {
            matches.push(current.name)
        }
    }
})