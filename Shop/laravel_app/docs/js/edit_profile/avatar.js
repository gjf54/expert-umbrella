$(document).ready(function () {
    $('#avatar').change(function () {
        $('#selected_file').text('Your selected file: ' + $('#avatar')[0].files[0].name)
    })
})