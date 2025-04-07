$(document).ready(function(){
    $('#sendLog').click(function(){

        var mail=$("#mail").val();
        var passwd=$("#passwd").val();

        if (mail && passwd){

            $.ajax({
                url:"../../src/controllers/auth-api.php",
                type:"POST",
                contentType:"application/json",
                data:JSON.stringify({mail: mail, pass: passwd}),

                success: function(response){
                    console.log(response);  // Verificamos  si la respuesta contiene el success y redirect_url para enviar a la ventana de proyectos.
                    if (response.success){
                        window.location.href = response.redirect_url;
                    }
                    else {
                        alert(response.message);
                    }
                },

                error: function(xhr, status, error){
                    alert("Usuario o contraseña incorrectos.");
                    console.log(error);
                }
            });
        }
        else {
                ("Falta un campo por rellenar.");
            }
    })
})