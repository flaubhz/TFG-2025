$(document).ready(function(){

    //Función para mostrar la ventana modal de añadir proyecto
    $('#addProjectBtn').click(function() {
        $('#formOverlay').addClass("activa");  //Añadir clase activa al fondo oscuro alrededor de la tarjeta modal para resaltar el modal
        $('#formAddProject').addClass("activa"); //Añadir la clase activa a la tarjeta modal que teníamos oculta para que se muestre y añadir proyecto
    });

    // Para cerrar el modal de añadir proyecto eliminando la clase (activa) que muestra la tarjeta (El mismo que en scheme)
    $('#closeCard').click(function() {
        $('#formOverlay').removeClass("activa");
        $('#formAddProject').removeClass("activa");
    });


    $("#save-btn").click(function(){
        var name= $("#name").val();

        $.ajax({
            url:"../../src/controllers/project-api.php",
            type: "POST",
            contentType:"application/json",
            data:JSON.stringify({name: name}), //Cuidado con el JSON Stringfy, revisar en todos los archivos ya que sino estoy enviando un OBJETO JS

            success:function(response) {
                console.log(response);
                alert("Proyecto añadido con éxito.");
                $('#formOverlay').removeClass("activa");
                $('#formAddProject').removeClass("activa");
                name=null;
            },

            error: function (xhr, status, error){
                alert("No se ha podido enviar el proyecto desde el JS.");
                console.log(error);
            }
        })
    })


})