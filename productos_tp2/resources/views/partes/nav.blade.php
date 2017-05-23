<nav class="navbar navbar-inverse bg-inverse  fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Tienda</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      
      

      <ul class="nav navbar-nav">
        <li class="active"><a href="{{route('home')}}">Inicio <span class="sr-only">(current)</span></a></li>
        @if (!Auth::guest())  
          @can('acceso_admin')
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" 
              aria-haspopup="true" aria-expanded="false">Productos
              <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('productos.create') }}">Nuevo</a></li>            
            <li><a href="{{ route('productos.index') }}">Listado</a></li>            
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" 
              aria-haspopup="true" aria-expanded="false">Categorias
              <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('categorias.create') }}">Nueva</a></li>            
            <li><a href="{{ route('categorias.index') }}">Listado</a></li>            
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" 
              aria-haspopup="true" aria-expanded="false">Promociones
              <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('promociones.create') }}">Nueva</a></li>
            <li><a href="{{ route('promociones.index') }}">Listado</a></li>            
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" 
              aria-haspopup="true" aria-expanded="false">Usuarios
              <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="{{ route('admin.usuarios.index') }}">Listado</a></li>            
          </ul>
        </li>
        @endcan
        @endif
        <li class="dropdown">
          <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" 
              aria-haspopup="true" aria-expanded="false">Catalogos
              <span class="caret"></span>
          </a>
        
          <ul class="dropdown-menu">
            <li><a href="{{ route('catalogo') }}">Catalogo</a></li>
            <li><a href="{{ route('compras.promociones.index') }}">Promociones</a></li>
            <li><a href="{{route('compras.facturas.index')}}">Mis Compras</a></li>
            <li><a href="#">Mas Vendidos</a></li>            
          </ul>
        </li>
      </ul>
      
      <ul class="nav navbar-nav navbar-right">
        @if (Auth::guest())
          <li><a href="{{ route('login') }}">Login</a></li>
          <li><a href="{{ route('register') }}">Register</a></li>
        @else
          <li><a href="{{route('compras.ver.carro')}}">{{ Session::get('cant_productos') }} Carro</a></li>

          <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" 
                 role="button" aria-expanded="false">
                {{ Auth::user()->name }} <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li>
                  <a href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">Logout
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                  </form>
                </li>
              </ul>
          </li>
        @endif   

      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>