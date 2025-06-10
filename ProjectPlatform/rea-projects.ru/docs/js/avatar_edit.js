$(document).ready(function () {
    $('#avatar').change(function () {
        $('#selected_file').text('Выбранный файл: ' + $('#avatar')[0].files[0].name)
    })
})