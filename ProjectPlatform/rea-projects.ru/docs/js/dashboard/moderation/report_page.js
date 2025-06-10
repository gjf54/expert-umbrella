function ban_user(report_id, login, report_description) {
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $.ajax({
        type: "POST",
        data: {
            login: login,
            reason: "Блокировки по жалобе #" + report_id + ". Причина: " + report_description,
            password: $("#password").val(),
        },
        url: $("#ban_user").attr("name"),
        success: function (response) {
            if(response == 1) {
                $("#ban_control").css('display', 'none')

                message = $('#success_message')
                message.text("Пользователь успешно заблокирован!")
                message.css('display', 'block')

                setTimeout(() => {
                    message.css('display', 'none')
                }, 5000)

                return
            }

            message = $('#fail_message')
            message.text("Что-то пошло не так! Проверьте правильность пароля и повторите попытку!")
            message.css('display', 'block')
            
            setTimeout(() => {
                message.css('display', 'none')
            }, 5000)
            
            return
        },
        error: function (response) {
            if(response.status == 401) {
                window.location.replace('/login')
            }
            console.log('Report service error - data was not synchronized');
        }
    });
}

function remove_report(id) {
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $.ajax({
        type: "POST",
        data: {
            report_id: id
        },
        url: $("#remove_report").attr("name"),
        success: function (response) {
            if(response == 1) {
                return window.location.replace(reports_url)
            }

            message = $('#fail_message')
            message.text("Что-то пошло не так! Повторите попытку позже!")
            message.css('display', 'block')
            
            setTimeout(() => {
                message.css('display', 'none')
            }, 5000)
            
            return
        },
        error: function (response) {
            if(response.status == 401) {
                window.location.replace('/login')
            }
            console.log('Report service error - data was not synchronized');
        }
    });
}

function remove_project(id) {
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $.ajax({
        type: "POST",
        data: {
            project_id: id,
        },
        url: $("#remove_project").attr("name"),
        success: function (response) {
            if(response == 1) {
                return window.location.replace(reports_url)
            }

            message = $('#fail_message')
            message.text("Что-то пошло не так! Повторите попытку позже!")
            message.css('display', 'block')
            
            setTimeout(() => {
                message.css('display', 'none')
            }, 5000)
            
            return
        },
        error: function (response) {
            if(response.status == 401) {
                window.location.replace('/login')
            }
            console.log('Report service error - data was not synchronized');
        }
    });
}
