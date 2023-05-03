listarCursos();



function listarCursos() {
    var csrf_token = token.content;
    var resultado = document.getElementById('resultado');


    let formdata = new FormData();
    formdata.append('_token', csrf_token);

    let ajax = new XMLHttpRequest();
    ajax.open('POST','getCurso_profe')
    ajax.onload=()=>{
        if(ajax.status == 200){
            let box = '';
            let cursos = JSON.parse(ajax.responseText);
            cursos.forEach(function(element) {
                box += `
                <li>
                    <i class='bx bxs-calendar-check'></i>
                    <span class="texto">
                        <h3>${element.nombre}</h3>
                    </span>
                </li> 
                `
            });
            resultado.innerHTML = box;
        }
    }
    ajax.send(formdata)
}