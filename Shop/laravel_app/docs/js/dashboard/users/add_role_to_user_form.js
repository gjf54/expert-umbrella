$input = $('.typeahead')

$.ajax({
    url: get_logins_url,
    method: "POST",
    success: function (logins) {
        $input.typeahead({
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