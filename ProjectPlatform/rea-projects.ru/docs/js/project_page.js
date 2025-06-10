function like(id) {  
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $.ajax({
        type: "POST",
        url: like_url,
        success: function (response) {

            let likes_field = $('#project_likes_field')
            likes_field.text(response);

            return
        },
        error: function (response) {
            if(response.status == 401) {
                window.location.replace('/login')
            }
            console.log('Like service error - data was not synchronized');
        }
    });
}

function switch_form() {  
    report_form = $("#report_form")
    if(report_form.css("visibility") == "hidden") {
        report_form.css("visibility", "visible")
    } else {
        report_form.css("visibility", "hidden")
    }
}

function send_report() {
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $.ajax({
        type: "POST",
        data: {
            project_id: project_id,
            report_text: $('#report_text').val(),
        },
        url: report_url,
        success: function (response) {

            console.log(response)

            if(response == '403') {
                window.location.replace('/login')
                return 
            }

            if(response) {
                switch_form()
                
                message = $("#success_message") 
                message.css('display', 'block')
                message.text("Жалоба отправлена!");

                setTimeout(() => {
                    message.css("display", "none")
                    message.text("")
                }, 5000)

                return 
            }

            return
        },
        error: function (response) {
            if(response.status == 401) {
                window.location.replace('/login')
                return
            }
            if(response.status == 489 || response.status == 490) {
                console.log(response.responseJSON["message"]);

                message = $("#fail_message") 
                message.css('display', 'block')
                message.text(response.responseJSON["message"])

                setTimeout(() => {
                    message.css("display", "none")
                    message.text("")
                }, 5000)

                return
            }
            
            console.log('Report service error - data was not synchronized');
        }
    });
}
