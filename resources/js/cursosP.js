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
          let asignaturas = curso.elementos.map(asignatura => `<option>${asignatura}</option>`).join("");
          let cursoHTML = `
            <li>
              <i class='bx bx-library'></i>
              <span class="texto">
                <h3 id="asignaturasN">${curso.nombre}</h3>
                <select class="desplegable">${asignaturas}</select>
              </span>
            </li>
          `;
          resultado.innerHTML += cursoHTML;
        }
      }
    };
    ajax.send(formdata);
}
  