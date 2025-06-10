$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
})

$.ajax({
    url: checkAuth,
    type: 'POST',
    success: function(data) {
        profileButton = $(".profile_title")
        if(!data['ifAuth']) {
            profileButton.text('Войти')
        }else {
            profileButton.text('Профиль')
        }

        profileButton.animate({
            opacity: '+=25',
        }, 4000)
    },
    error: function(data) {
        console.log('Main Layout error - data was not fetched')
        profileButton = $(".profile_title")

        profileButton.css('background-color', '#FFF')
        profileButton.css('border', '4px solid red')
        profileButton.text("ERR");

        profileButton.attr("href", "/");

        profileButton.animate({
            opacity: '+=25',
        }, 4000)
    },
})