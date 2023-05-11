listarHorario();

function listarHorario() {
  const resultado = document.getElementById('horario');
  const ajax = new XMLHttpRequest();
  ajax.open('GET', 'horariosCurso');
  ajax.onload = () => {
    if (ajax.status == 200) {
      const horario = JSON.parse(ajax.responseText);
      console.log(horario);

      const horas = [];
      const dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
      for (const sesion in horario) {
        // console.log(horario[sesion].nombre);
        const hora = horario[sesion].hora_inicio;
        if (!horas.includes(hora)) {
          horas.push(hora);
        }
      }

      horas.sort();

      let box = '';
      horas.forEach(function (element) {
        const horaInicio = moment(element, 'HH:mm:ss');
        const horaFin = horaInicio.clone().add(55, 'minutes');
        let dia = 0;
        let encontrado = false;
        let x = 1;
        box += `
          <tr>
            <td>${horaInicio.format('HH:mm')} - ${horaFin.format('HH:mm')}</td>`;
        for (var i = 0; i < horario.length; i++) {
          var sesion = horario[i];
          if(dia <= 4){
            if (sesion.hora_inicio == element && dias[dia] == sesion.dia) {
              box += `<td>${sesion.nombre}</td>`;
              dia++;
              encontrado = true;
              i = -1; // Agrega esta línea para salir del bucle cuando se encuentra una sesión
              x = 0;
            } else {
              encontrado = false;
            }
            if (!encontrado && x == horario.length) {
              box += `<td>-</td>`;
              // x = 0;
              i = -1;
              dia++;
            }
            x++;
          }
          
        }
        
        box += `</tr>`;
        
      });
      
      
      
      resultado.innerHTML = box;
    }
  };
  ajax.send();
}