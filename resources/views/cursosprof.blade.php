<script src="{!! asset('../resources/js/cursosP.js') !!}"></script>
<script src="{!! asset('../resources/js/datos.js') !!}"></script>

<div id="paneldecontrol">
    @yield('contenido')
    <ul class="box-info" id="resultado">
    </ul>
</div>

@section('contenido')
@endsection
<div id="resultadoexcel">

</div>
