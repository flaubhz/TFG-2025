$(document).ready(function () {
    $.ajax({
        url: "../../src/controllers/scheme-api.php",
        type: "GET",
        contentType: "application/json",
        success: function (response) {

            let loadTasks = response;

            loadTasks.forEach(task => {
                let taskCard=
                `<div class="taskCard">
                    <div class="taskInfo"><p class="title">${task.Nombre}</p></div>
                    <div class="taskInfo"><p class="info">${task.Encargado}</p></div>
                    <div class="taskInfo"><p class="info">${task.Fecha_limite}</p></div>
                    <div class="taskInfo"><p class="info">${task.Prioridad}</p></div>
                    <div class="taskInfo"><p class="info">${task.Estado}</p></div>
                </div>`;
                if(task.Estado=="Iniciado"){
                    $('#start').append(taskCard);
                }
                else if(task.Estado=="En_proceso"){
                    $('#inProcess').append(taskCard);
                }
                else if(task.Estado=="Finalizado"){
                    $('#end').append(taskCard);
                }
                $('#tasks').append(taskCard);
            });
        },
        error: function (xhr, status, error) {
            alert("Error al cargar los datos.");
            console.log(error);
        }
    });
});
