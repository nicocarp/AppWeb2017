<a class="link_tarjeta thumbnail">          
	<div class="row">
		<div class="col-md-2">
			<img class="img-thumbnail img-check"
			src="{{asset('imagenes/carp/'.$producto->ruta_imagen)}}" alt="...">
		</div>
		<div class="col-md-5 text-center">
			<p class="nombre-prod">{{$producto->nombre}}</p>
			<p class="">Stock {{$producto->stock}}</p>
		</div>
		<div class="col-md-5 text-center">
			<p class="">$ {{$producto->precio}}</p>
		</div>		
	</div>	
</a>



