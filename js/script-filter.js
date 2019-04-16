$(document).ready(function(){
    $("#doneFilter").change(function(){
        $(this).parent().submit();
    });
});