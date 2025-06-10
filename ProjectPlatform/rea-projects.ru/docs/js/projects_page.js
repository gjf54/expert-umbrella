function get_projects(text) {
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $.ajax({
        type: "POST",
        data: {name: text},
        url: search_data_url,
        success: function (response) {
            $("#search_list > li").remove();
            response.forEach(element => {
                let search_list = $("#search_list")
                let li = document.createElement("li")
                let a = document.createElement("a")

                let count = 0;
                for (let i = 0; i < 40 && element[0][i]; i++, count++) { 
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
        let text = search_input.value
        get_projects(text)
    })

    search_button.addEventListener("click", function (e) {
        e.preventDefault()
        let url = search_url + search_input.value
        window.location.replace(url)
    })
}
