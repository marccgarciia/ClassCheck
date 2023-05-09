var resultado = document.getElementById('horario');
listarHorario();
function listarHorario() {  
  let ajax = new XMLHttpRequest();
  ajax.open('GET', 'horariosCurso');
  ajax.onload = () => {
    if (ajax.status == 200) {
      let horario = JSON.parse(ajax.responseText);
      let horas = [];

      for (sesion in horario) {
        let hora = horario[sesion].hora_inicio;
        if(!horas.includes(hora)){
          horas.push(hora);
        }
      }
      horas.sort();
      console.log(horas);
    }
  };
  ajax.send();
}   

  
function mostrarHorario(horario) {
    
  
    // // Agregar los datos de las asignaturas al horario
    // for (var i = 0; i < horario.length; i++) {
    //   var dia = dias.indexOf(horario[i].dia);
    //   var hora_inicio = parseInt(horario[i].hora_inicio.split(':')[0]);
    //   var hora_fin = parseInt(horario[i].hora_fin.split(':')[0]);
    //   var duracion = hora_fin - hora_inicio;
  
    //   // Agregar la asignatura a las celdas correspondientes
    //   for (var j = 0; j < duracion; j++) {
    //     var fila = tabla.rows[hora_inicio - 7 + j + 1];
    //     var celda = fila.cells[dia + 1];
    //     celda.innerHTML = horario[i].nombre;
    //     celda.rowSpan = duracion;
    //   }
    // }
  
    resultado.appendChild(tabla);
}
  