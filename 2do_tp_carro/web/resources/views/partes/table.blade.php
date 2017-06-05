<table>
	<thead>
		@foreach ($titulos_columna as $titulo_columna)
			<th>{{$titulo_columna}}</th>
		@endforeach		
	</thead>
	<tbody>
		@foreach ($items as $item)
		<tr>
			<td>
				<a href="{{$renglon->url_show}}"
				class="btn btn-info" aria-hidden="true">
				<span class="glyphicon glyphicon-zoom-in"></span>
				</a>
			</td>
			@foreach ($renglon->columnas as $columna)
				<td>{{$columna}}</td>
			@endforeach
			<td>
				<a href="{{ $renglon->url_edit }}"
					class="btn btn-warning" aria-hidden="true">
					<span class="glyphicon glyphicon-wrench"></span>
				</a>
				<a href="{{ $renglon->url_destroy}}"
				class="btn btn-danger" aria-hidden="true">
				<span class="glyphicon glyphicon-remove-circle"></span>
				</a>
			</td>
		</tr>
		@endforeach
	</tbody>

</table>