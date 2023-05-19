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
          console.log(curso);
          let asignaturas = curso.elementos
            .map(
              (asignatura) =>
                `<li id="${asignatura.id}"><p class="ca">- ${asignatura.nombre}</p></a></li>`
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
              elementos.style.display = "block";
              event.currentTarget.parentElement.style.height = `${
                event.currentTarget.parentElement.offsetHeight + elementos.offsetHeight
              }px`;
            }
            // De lo contrario, oculta los elementos y reduce el tamaño del contenedor
            else {
              event.currentTarget.parentElement.style.height = `${
                event.currentTarget.parentElement.offsetHeight - elementos.offsetHeight
              }px`;
              elementos.style.display = "none";
            }
          });
        });
      }
    };
    ajax.send();
}
  