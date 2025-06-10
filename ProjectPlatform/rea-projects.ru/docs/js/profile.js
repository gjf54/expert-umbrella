function show_edit_list() { 
    let edit_list = $('#user_edit_list')

    if(edit_list.css('display') == 'none') {
        edit_list.css('display', 'flex')
    } else {
        edit_list.css('display', 'none')
    }
}