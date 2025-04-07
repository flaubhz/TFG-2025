$(document).ready(function() {


    $('#addTaskBtn').click(function() {
        $('#formOverlay').addClass("activa"); //Clase con la que hacemos visible la tarjeta modal para añadir una tarea
        $('#formAddTask').addClass("activa");
    });

    // Cerramos el modal de añadir tarea eliminando la clase (activa) que muestra la tarjeta
    $('#closeCard').click(function() {
        $('#formOverlay').removeClass("activa");
        $('#formAddTask').removeClass("activa");
    });

    //Enviamos el contenido de la tarea pulsando en enviar y guardando en variables los datos
    $("#save-btn").click(function() {
        var name = $('#name').val();
        var responsible = $('#responsible').val();
        var deadline = $('#deadline').val();
        var priorities = $('#priorities').val();
        var state = $('#states').val();

        console.log(taskData)

        $.ajax({
            url: "../../src/controllers/scheme-api.php",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({name: name, responsible: responsible,deadline:deadline, priorities:priorities, state:state}),
                

            success: function(response) {
                console.log(response);
                alert("Tarea añadida con éxito");
            },
            error: function(xhr, status, error) {
                alert("Error al añadir la tarea.");
                console.log(error);
            }
        });
    });
});
