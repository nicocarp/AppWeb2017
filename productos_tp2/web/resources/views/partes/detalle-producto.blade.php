<div class="row">
	<div class="col-md-6">
		<img class="" src="{{asset('imagenes/carp/'.$producto->ruta_imagen)}}">
	</div>
	<div class="col-md-6">
		<p class="nombre-prod" style="font-size:150%"><strong>{{$producto->nombre}}</strong></p>
	    <div class="form-group">
	    	<label name="stock" class="label label-default">{{$producto->categoria->nombre}}</label>
        </div>
        <div class="form-group">
	    	<p>{{$producto->descripcion}}</p>	        		        
	    </div>
	    <div class="form-group">
	    	@if ( $producto->stock > 0 )
	    		<label name="stock" class="label label-success"> En Stock!</label>
	    	@else
	    		<label name="stock" class="label label-danger"> Sin Stock!</label>
	    	@endif	    	
	    </div>    

	    <div class="form-group">
        	<p class="producto_precio" id="precio_sub_total">$ {{$producto->precio}}</p>		
        </div>
        <div class="form-group">
			<form id="form_add_carro" method="post" action="{{route('compras.add.carro')}}" >
				{{ csrf_field() }}
				<label for="recipient-name" class="control-label">Cantidad:</label>
            	<input name="cantidad" type="number" min="1" value="1" class="form-control" id="input_cant">
            	<input name="producto_id" hidden value="{{$producto->id}}">          	
			</form>
         </div>

	</div>	
</div><br>

