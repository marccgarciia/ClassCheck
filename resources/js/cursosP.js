listarCursos();

function listarCursos() {
  var csrf_token = token.content;
  var resultado = document.getElementById('resultado');

  
  let formdata = new FormData();
  formdata.append('_token', csrf_token);

  let ajax = new XMLHttpRequest();
  ajax.open('POST', 'getCurso_profe');
  ajax.onload = () => {
    if (ajax.status == 200) {
      let cursos = [];
      let elm = JSON.parse(ajax.responseText);
      elm.forEach(function (element) {
        let cursoIndex = cursos.findIndex((curso) => curso.nombre === element.curso);
        if (cursoIndex === -1) {
          cursos.push({
            nombre: element.curso,
            elementos: [element.nombre]
          });
        } else {
          cursos[cursoIndex].elementos.push(element.nombre);
        }
      });
      for (let i in cursos) {
        let curso = cursos[i];
        let asignaturas = curso.elementos.map(asignatura => `<p>${asignatura}</p>`).join("");
        let cursoHTML = `
            
            <li>
              <i class='bx bx-library'></i>
              <span class="texto">
                <h3 class="titulo" id="asignaturasN">${curso.nombre}</h3>
                <div class="elementos">${asignaturas}</div>
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
            event.currentTarget.parentElement.style.height = `${event.currentTarget.parentElement.offsetHeight + elementos.offsetHeight}px`;
          } 
          // De lo contrario, oculta los elementos y reduce el tamaño del contenedor
          else {
            event.currentTarget.parentElement.style.height = `${event.currentTarget.parentElement.offsetHeight - elementos.offsetHeight}px`;
            elementos.style.display = "none";
          }
        });
      });



    }
  };
  ajax.send(formdata);
  
}