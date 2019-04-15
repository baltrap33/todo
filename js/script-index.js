$(document).ready(function(){
    $("#doneFilter").change(function(){
        $(this).parent().submit();
    });
    $(".input-checked").change(function(){
        let state = $(this).prop("checked");
        let idTodo = $(this).attr("data-value");
        $.ajax({
            url: "/switch.php ",
            type: "POST",
            data: {
                id: idTodo,
                state: state,
            }
        }).then(function(response){
            let result = response.updated;
            if(result === "success"){
                toastr.success('la tâche a été mise à jour.');
                let todo = response.todo, updatedAt = todo.updated_at;
                $(".todo-updated-at",$("#todo-row-id-"+idTodo)).text(updatedAt);
            }else{
                toastr.info('la tâche sélectionnée n\'est pas disponible.');
            }

        }).catch(function(){
            toastr.error('contacter l\'administrateur système.','une erreur est survenue');
        });
    });
});