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
        success: function() {
            let ban = $('#ban-' + id)
            ban.remove()
        },
        error: function () {
            console.log('error synchronize data')
        },
    })
    
}

function get_projects(login) {
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $.ajax({
        type: "POST",
        data: {"login": login},
        url: search_data_url,
        success: function (response) {
            $("#search_list > li").remove();
            console.log(response)
            response.forEach(element => {
                let search_list = $("#search_list")
                let li = document.createElement("li")
                let a = document.createElement("a")

                let count = 0;
                
                a.innerText += '@'

                for (let i = 0; i < 39 && element[0][i]; i++, count++) { 
                    a.innerText += element[0][i]
                }

                if(count == 30) {
                    a.innerText += '...'
                }

                a.href = element[1]

                li.append(a)
                search_list.append(li)
            })
        },
        error: function (response) {
            console.log('Search bar error - data was not fetched');
        }
    })
}


window.onload = () => {
    let search_input = document.querySelector("#search_input")
    let search_button = document.querySelector("#search_button")

    search_input.addEventListener("input", function (e) {  
        let login = search_input.value
        get_projects(login)
    })

    search_button.addEventListener("click", function (e) {
        e.preventDefault()
        let url = search_url + search_input.value
        window.location.replace(url)
    })
}

