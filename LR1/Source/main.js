
$(document).ready(function() {
    $(".delete_guard").click(function(){
        if (window.confirm("Вы точно хотите удалить запись?")) {
            window.location.replace('/LR1/guards/delete/'+$(this).attr("id"));
        }
    });

    $("#flexRadioDefault2").click(function (){
        if ($(this).is(':checked')) {
            $('#id_guard_post').removeAttr('disabled');
        }
    });

    $("#flexRadioDefault1").click(function (){
        if (!$('#flexRadioDefault2').is(':checked')) {
            $('#id_guard_post').prop('disabled', true);
        }
    });
});
