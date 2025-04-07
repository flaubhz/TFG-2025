$(document).ready(function () {

    //  Llamada al projectId en la URL
    $.ajax({
        url: `../../src/controllers/project-api.php`,  // Incluir el projectId en la URL (Funciona)
        type: "GET",
        contentType: "application/json",
        success: function (response) {
        
            let loadProjects = response; // Variable para cargar los proyectos
            console.log(loadProjects);
            // Selecciona el contenedor donde se agregarán las tarjetas de proyectos
            let projectsContainer = $("#projectsContainer");

            // Iterar sobre los proyectos y crear una tarjeta para cada uno
            loadProjects.forEach(project => {
                let projectCard = //HAY QUE VINCULAR EL PROJECT ID CON EL SCHEME ID
                `<a href="ruta/a/la/pantalla/del/proyecto/${project.Id}" class="projectLink">
                <div class="projectCard">
                    <div class="taskInfo"><p class="title">${project.Nombre}</p></div>
                </div>`;
                
                // Agrega la tarjeta de proyecto al contenedor
                projectsContainer.append(projectCard);
            });
        },
        error: function (xhr, status, error) {
            alert("Error al cargar los datos.");
            console.log(error);
        }
    });
});
