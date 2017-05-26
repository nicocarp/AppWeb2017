<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    	<link href="{{ url('css/app.css') }}" rel="stylesheet">
        <link href="{{ url('css/utils.css') }}" rel="stylesheet">
        <link href="{{ url('css/bootstrap.css') }}" rel="stylesheet">
        <title> @yield('title') </title>
        <link href="{{ url('css/bootstrap-theme.min.css') }}" rel="stylesheet">
        <link href="{{ url('css/bootstrap-datepicker.min.css') }}" rel="stylesheet">

        <!-- Fonts -->
        
	</head>
    <body>
        @include('partes.nav')
        <div class="container">
            <div class="row">
                <nav>                          
                     @yield('navegate_tags') 
                </nav>                    
            </div>
            <div class="row">
                <div class="container">
                    @include('partes.flash-message')
                </div>

                <div class="col-md-8 col-md-offset-2 col-sm-12 col-sm-offset-0">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">                            
                            <h4>@yield('section_title')
                                <a href="javascript:history.back()" class=" pull-left">
                                    <span class="glyphicon glyphicon-arrow-left "></span>
                                </a>
                                <a href="@yield('url_alta')" class=" pull-right">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </a>                                
                            </h4>

                        </div>
                        <div class="panel-body">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @yield('content')                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

    </body>
    <script src="{{ asset('js/app.js') }}"></script>
    
    <script src="{{ asset('js/bootstrap-datepicker.js') }}" charset="UTF-8"></script>
    <script src="{{ asset('locales/bootstrap-datepicker.es.min.js') }}" charset="UTF-8"></script>
    @section('scripts')
    <script type="text/javascript">
    
            $('div.alert').not('.alert-important').delay(5000).fadeOut(350);
            setTimeout(function() { $(".alert").hide(); }, 5000);
            window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};
    </script>
    @show
    
    
    
</html>
