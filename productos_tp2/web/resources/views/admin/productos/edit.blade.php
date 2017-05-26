@extends('layouts.base-create')
@section('title', 'Editando Producto')
@section('navegate_tags')
	<a href="{{route('home')}}">Home</a> |
	<a href="{{route('productos.index')}}">Productos</a> |
	<a href="{{route('productos.edit', $producto->id)}}">Editar</a> |
@endsection
@section('section_title', 'Editar un Producto')
@section('url_alta', route('productos.create'))

@section('content_form')
	
	{!! Form::open(['route' => ['productos.update',$producto->id], 
								'method' => 'PUT', 'files'=>true]) !!}

<div class="row">
	<div class="col-md-6">
        {{ Html::image('imagenes/carp/'.$producto->ruta_imagen,null,
                ['alt'=>'Imagen Carp', 'id'=>'imagen_div']
            ) }}
        
        <div class="form-group">
            {{ Form::label('ruta_imagen', 'Imagen') }}
            {{ Form::file('ruta_imagen',null, ['onchange'=>'loadFile(event)']) }}
		</div>
    </div>

	<div class="col-md-6">

	    <div class="form-group">
	        {{ Form::label('nombre', 'Nombre') }}
	        {{ Form::text('nombre', $producto->nombre, ['class' => 'form-control']) }}
	    </div>

	    <div class="form-group">
	        {{ Form::label('descripcion', 'Descripcion') }}
	        {{ Form::text('descripcion', $producto->descripcion, ['class' => 'form-control']) }}
	    </div>

	    <div class="form-group">
	        {{ Form::label('precio', 'Precio') }}
	        {{ Form::text('precio', $producto->precio, ['class' => 'form-control']) }}
	    </div>

	    <div class="form-group">
	        {{ Form::label('stock', 'Stock') }}
	        {{ Form::text('stock', $producto->stock, ['class' => 'form-control']) }}
	    </div>
	    
	    
	    <div class="form-group">
            {{ Form::label('categoria_id', 'Categoria') }}
            {{ Form::select('categoria_id', $categorias
                    , $producto->categoria_id, ['class' => 'form-control']) }}
        </div>
        

	    {!! Form::submit('Editar', ['class' => 'btn btn-primary',
	                        'data-loading-text' => "Loading...",
	                        'autocomplete' => "off",
	                        'id' => 'id_btn_submit_form'
		]) !!}
	{!! Form::close() !!}
</div>
</div>
@endsection
@section('scripts')
@parent
<script type="text/javascript">    
    $('#ruta_imagen').change(function(event){
        var reader = new FileReader();
        reader.onload = function(){
          var output = document.getElementById('imagen_div');
          output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });
  
</script>
@endsection