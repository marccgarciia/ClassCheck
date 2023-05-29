listarCursos();

function listarCursos() {
  var resultado = document.getElementById('resultado');

  let ajax = new XMLHttpRequest();
  ajax.open('GET', 'getCurso_profe');
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
        let asignaturas = curso.elementos.map(asignatura => `<a  href="./datos/${asignatura.id}"><p class="ca">${asignatura.nombre}</p></a>`).join("");
        let cursoHTML = `
          <li>
          <i class='bx bxs-store-alt'></i>
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
      cargaCurso();
    }
  };
  ajax.send();
  
}

function cargaCurso() {
  // agrega un controlador de eventos para los clics en los enlaces de la barra lateral
  var sidebarLinks = document.querySelectorAll('.box-info a');
  sidebarLinks.forEach(function(link) {
      link.addEventListener('click', function(event) {
          // previene el comportamiento predeterminado del enlace (navegar a una nueva página)
          event.preventDefault();

          // borra el contenido anterior del contenedor principal
          var contenedorContenido = document.getElementById('paneldecontrol');
          contenedorContenido.innerHTML = '';

          // obtiene la URL del archivo blade asociado con el enlace
          var url = this.getAttribute('href');

          // crea una instancia del objeto XMLHttpRequest
          var xhr = new XMLHttpRequest();
          xhr.onreadystatechange = function() {
              if (xhr.readyState === 4 && xhr.status === 200) {
                  // actualiza el contenido del contenedor principal con la respuesta de la solicitud
                  contenedorContenido.innerHTML = xhr.responseText;
                  listaClase();
                }
          };

          // envía una solicitud AJAX para obtener el contenido del archivo blade
          xhr.open('GET', url, true);
          xhr.send();
      });
  });
};