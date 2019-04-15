function createCategory(name, id){
    let button = '<button type="button" data-id="category-id-'+id+'" class="btn-input btn btn-success mr-2">' +
        '<input type="hidden" name="categoriesIds[]" value="'+id+'"/>'+
        '<span class="mr-3">'+name+'</span><i class="fas fa-times"></i></button>';
    $("#categories").append(button);
    launchListener();
}

function launchListener(){
    $(".btn-input").off().click(function(){
        let id = $(this).attr("data-id");
        $("#"+id).show();
        $(this).remove();
    });
}
$(document).ready(function(){
    $(".add-category").click(function(){
        let value = $(this).attr("data-value");
        let name = $(this).attr("data-name");
        $(this).hide();
        createCategory(name, value);
    });
});