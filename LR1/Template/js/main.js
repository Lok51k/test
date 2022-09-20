$(document).ready(function() {
    $(".DeletePhoto").click(function(){
        if (window.confirm("Вы точно хотите удалить запись?")) {
            window.location.replace('/LR1/photoDel.php?id='+$(this).attr("id"));
        }
    });
    $(".DeleteType").click(function(){
        window.location.replace('/LR1/typeDel.php?id='+$(this).attr("id"));
    });

    $("#flexRadioDefault2").click(function (){
       if ($(this).is(':checked')) {
           $('#type_photo').removeAttr('disabled');
       }
    });

    $("#flexRadioDefault1").click(function (){
        if (!$('#flexRadioDefault2').is(':checked')) {
            $('#type_photo').prop('disabled', true);
        }
    });
});



