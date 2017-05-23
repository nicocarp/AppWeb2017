@extends('layouts.base-lista')
@section('title','Promociones')
@section('navegate_tags')
	<a href="{{route('home')}}">Admin</a> |
	<a href="{{route('promociones.index')}}">Promociones</a> |	
@endsection

@section('section_title', 'Listado de todas las Promociones Activas')
@section('url_alta', route('promociones.create'))

@section('content_form_filtro')
{!! Form::open(['route' => 'promociones.index', 'method' => 'GET']) !!}

    	<div class="form-group col-md-4">	
    		<label for="check_activo">Activo</label>
			<input class="check_filtros" value="true" id="check_activo" type="checkbox">
        </div>
        <div class="form-group col-md-4">	
        	<label for="check_estara_activo">Estara Activo</label>
			<input class="check_filtros" value="true" id="check_estara_activo" type="checkbox">
        </div>
        <div class="form-group col-md-4">	
        	<label for="check_no_activo">No Activo</label>
			<input class="check_filtros" value="true" id="check_no_activo" type="checkbox">
        </div>        
        
	{!! Form::close() !!}
@endsection




@section('content_th_table')	
	<th>#</th><th>Fecha Ini</th><th>Fecha Fin</th></th><th>Cantidad</th><th>Estado</th><th>Accion</th>
@endsection

@section('content_tr_table')
	@foreach ($promociones as $promocion)
		<tr class="tr_filtros" data-estado-promo="{{$promocion->getEstado()}}">
			<td>
				<a href="{{ route('promociones.show', $promocion->id) }}"
				class="btn btn-info" aria-hidden="true">
				<span class="glyphicon glyphicon-zoom-in"></span>
				</a>
			</td>
			<td>{{ $promocion->fecha_ini }}</td>
			<td>{{ $promocion->fecha_fin }}</td>
			<td>{{ $promocion->cantidad }}</td>
			<td>
				@php
					switch( $promocion->getEstado()){
					case 1: 
					    echo '<span class="label label-success">Activo</span>';
					    break;
					case 2:
						echo '<span class="label label-warning">Estara Activo</span>';
						break;
					case  0:
					 	echo '<span class="label label-default">No Activo</span>';
					 	break;
					}					
				@endphp
				
				
				
				
			</td>
			<td>
				<a href="{{ route('promociones.edit', $promocion->id) }}"
				class="btn btn-warning" data-method="delete" aria-hidden="true">
				<span class="glyphicon glyphicon-wrench"></span>
				</a>
				<a href="{{ route('admin.promociones.destroy', $promocion->id) }}"
				class="btn btn-danger" data-method="delete" aria-hidden="true">
				<span class="glyphicon glyphicon-remove-circle"></span>
			</a>
			</td>
		</tr>
	@endforeach		
@endsection


@section('scripts')
<script type="text/javascript">	
	function ocultar_tr(estados){		
		$('.tr_filtros').each(function(index){				
			result = $.inArray($(this).data('estadoPromo'), estados); 
			if (result != -1)
				$(this).prop("hidden", false);
			else
				$(this).prop("hidden", true);
		});
	}

	function aplicar_filtros(){
		var estados_a_filtrar = [];
		if ($('#check_activo').prop('checked'))
			estados_a_filtrar.push(1);
		if ($('#check_estara_activo').prop('checked'))
			estados_a_filtrar.push(2);
		if ($('#check_no_activo').prop('checked'))
			estados_a_filtrar.push(0);		
		ocultar_tr(estados_a_filtrar);
	}
	/* Eventos para los filtros */
	$('.check_filtros').change(aplicar_filtros);
	/*Configuracion inicial de los filtros*/
	$('#check_activo').prop('checked',true);
	$('#check_estara_activo').prop('checked',true);
	$('#check_no_activo').prop('checked',true);
	aplicar_filtros();	

</script>
@endsection