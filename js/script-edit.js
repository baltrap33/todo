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
    let fileHtml = '<label for="task">Ajouter une image :</label>' +
        '<input type="file"' +
        'class="form-control-file"' +
        'id="imgTodo" name="imgTodo" />';
    $("#btn-add-img").click(function(){
        $(this).hide();
        $("#edit-form").attr("enctype","multipart/form-data");
        $("#file-group-container").html(fileHtml);
    });
    $("#btn-delete-img").click(function(){
        $("#img-btn-group").hide();
        $("#current-img").attr("src","./images/default.jpg");
        $("#edit-form").attr("enctype","multipart/form-data");
        $("#file-group-container").html(fileHtml).append('<input type="hidden" name="delete" value="true"/>');
    });
    $("#btn-change-img").click(function(){
        $("#img-btn-group").hide();
        $("#edit-form").attr("enctype","multipart/form-data");
        $("#file-group-container").html(fileHtml);
    });
    $(".add-category").click(function(){
        let value = $(this).attr("data-value");
        let name = $(this).attr("data-name");
        $(this).hide();
        createCategory(name, value);
    });
    launchListener();
});