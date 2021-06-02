@extends('layouts.app')

@section('content')
    @if (session()->has('data'))
    <script type="text/javascript">
        window.location = "{{ url('/') }}";//here double curly bracket
    </script>
    @else
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="panel-title">Acceso a la aplicacion</h1>
                </div>
                <div class="panel_body">
                    <form action="{{route('login')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="email">email</label>
                            <input class="form-control" 
                            type="email" 
                            name="email" 
                            placeholder="Ingresa tu email">
                            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                        </div>
                        <div class="form-group">
                            <label for="contraseña">contraseña</label>
                            <input class="form-control" 
                            type="password" 
                            name="password" 
                            placeholder="Ingresa tu email"
                            required>
                            {!! $errors->first('contraseña', '<span class="help-block">:message</span>') !!}
                        </div>
                        <button class="btn btn-primary btn-block">Acceder</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
    
@endsection