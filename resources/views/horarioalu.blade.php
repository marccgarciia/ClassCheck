<script src="{!! asset('../resources/js/horarioAlu.js') !!}"></script>

<style>
		table {
			border-collapse: collapse;
			margin: 20px auto;
		}
		td {
			border: 1px solid black;
			padding: 10px;
			text-align: center;
			min-width: 100px;
			height: 60px;
			background-color: #f2f2f2;
			font-size: 18px;
			font-weight: bold;
			font-family: Arial, sans-serif;
		}
		.lunes {
			background-color: #ffe6e6;
		}
		.martes {
			background-color: #e6f7ff;
		}
		.miercoles {
			background-color: #e6ffe6;
		}
		.jueves {
			background-color: #f2f2f2;
		}
		.viernes {
			background-color: #f2e6ff;
		}
</style>

<div class="horario" id="horario">
	<table>
		<tr>
			<th>Hora</th>
			<th>Lunes</th>
			<th>Martes</th>
			<th>Miércoles</th>
			<th>Jueves</th>
			<th>Viernes</th>
		</tr>

	</table>
</div>

