@extends('layouts.base-create')
@section('title', 'Crear Producto')
@section('navegate_tags')
    <a href="{{route('home')}}">Admin</a> |
    <a href="{{route('productos.index')}}">Productos</a> |
    <a href="{{route('productos.store')}}">Nuevo</a> |
@endsection
@section('section_title', 'Agregar Nuevo Producto')
@section('url_alta', route('productos.create'))

@section('content_form')
    

<div class="row">
    {!! Form::open(['route' => 'productos.store', 'method' => 'POST', 'files'=>true]) !!}
    <div class="col-md-6">
        {{ Html::image('imagenes/carp/empty.png',null,
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
            {{ Form::text('nombre', null,array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('descripcion', 'Descripcion') }}
            {{ Form::text('descripcion', null,['class' => 'form-control']) }}
        </div>

        <div class="form-group">
            {{ Form::label('precio', 'Precio') }}
            {{ Form::text('precio', null, array('class' => 'form-control')) }}
        </div>

        <div class="form-group">
            {{ Form::label('stock', 'Stock') }}
            {{ Form::number('stock', 0, array('class' => 'form-control')) }}
        </div>

        

        <div class="form-group">
            {{ Form::label('categoria_id', 'Categoria') }}
            {{ Form::select('categoria_id', $categorias
                    , null, ['class' => 'form-control']) }}
        </div>
    </div>
        {!! Form::submit('Crear!', ['class' => 'btn btn-primary',
                            'data-loading-text' => "Loading...",
                            'autocomplete' => "off",
                            'id' => 'id_btn_submit_form'

        ]) !!}
    {!! Form::close() !!}
</div>


@endsection <!-- /.form_section -->
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
