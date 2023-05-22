listarCursoA();

function listarCursoA() {
  var resultado = document.getElementById('resultado');

  let ajax = new XMLHttpRequest();
  ajax.open('GET', 'getCurso_alu');
  ajax.onload = () => {
    if (ajax.status == 200) {
      let cursos = [];
      let elm = JSON.parse(ajax.responseText);
      elm.forEach(function (element) {
        let cursoIndex = cursos.findIndex((curso) => curso.nombre === element.curso);
        if (cursoIndex === -1) {
          cursos.push({
            nombre: element.curso,
            elementos: [{ nombre: element.nombre, id: element.id }],
          });
        } else {
          cursos[cursoIndex].elementos.push({ nombre: element.nombre, id: element.id });
        }
      });

      for (let i in cursos) {
        let curso = cursos[i];
        // console.log(curso);
        let asignaturas = curso.elementos
          .map(
            (asignatura) =>
              `<li id="${asignatura.id}" class="lialu"><p class="co">${asignatura.nombre}</p></a></li>`
          )
          .join("");
        let cursoHTML = `
            <li>
              <i class='bx bx-library'></i>
              <span class="texto">
                <h3 class="titulo" id="asignaturasN">${curso.nombre}</h3>
                <ul class="elementos">${asignaturas}</ul>
              </span>
            </li>
          `;
        resultado.innerHTML += cursoHTML;
      }

      // Selecciona todos los títulos de contenedor y les añade un controlador de eventos
      document.querySelectorAll(".titulo").forEach((titulo) => {
        titulo.addEventListener("click", (event) => {
          // Encuentra el div de elementos que está dentro del contenedor
          const elementos = event.currentTarget.nextElementSibling;

          // Si los elementos están ocultos, muéstralos y agranda el contenedor
          if (elementos.style.display === "none") {
            elementos.style.cssText = "display: flex; align-items: center; justify-content: center; flex-wrap:wrap;";
            event.currentTarget.parentElement.style.height = `${event.currentTarget.parentElement.offsetHeight + elementos.offsetHeight}px`;
          }
          // De lo contrario, oculta los elementos y reduce el tamaño del contenedor
          else {
            event.currentTarget.parentElement.style.height = `${event.currentTarget.parentElement.offsetHeight - elementos.offsetHeight}px`;
            elementos.style.display = "none";
          }
        });
        // Agregar evento de clic a cada asignatura
        titulo.nextElementSibling.querySelectorAll(".lialu").forEach((asignatura) => {
            asignatura.addEventListener("click", (event) => {
                let elementos = event.currentTarget.parentElement;
                elementos.parentElement.style.height = `${elementos.parentElement.offsetHeight - elementos.offsetHeight}px`;
                elementos.style.display = "none";

                const idAsignatura = event.currentTarget.id;
                const asignatura = event.currentTarget.querySelector(".co").textContent;
                calendar.removeAllEvents();
                listarFaltas(idAsignatura,asignatura);                
            });
          });
        });
      }
    };
    ajax.send();
}
  

function listarFaltas(idA,asignatura) {
    document.getElementById('asignaturaAlu').innerHTML = asignatura;
  let ajax = new XMLHttpRequest();
  ajax.open('GET', 'getFaltas_Alu/' + idA);
  ajax.onload = () => {
    if (ajax.status == 200) {
        respuesta = JSON.parse(ajax.responseText);
            console.log(respuesta);
            respuesta.forEach(function (falta) {
                // console.log(falta);
                let tipo = "";

                let colorF = "";
                if(falta.id_tipo_asistencia == 2){
                    colorF = '#DB504A';
                }else if(falta.id_tipo_asistencia == 3){
                    colorF = 'rgb(228, 166, 92)';
                }

                // Crear un nuevo evento en el calendario para la falta de asistencia
                calendar.addEvent({
                    title: falta.hora_inicio,
                    start: falta.fecha_asistencia, // Ajustar la fecha según tus necesidades
                    allDay: true, // Indicar que el evento ocurre durante todo el día
                    color: colorF, // Establecer el color del evento
                    extendedProps: {
                        falta: falta.id,
                    }
                });
                
            });   
    }
    }
    ajax.send();
}
