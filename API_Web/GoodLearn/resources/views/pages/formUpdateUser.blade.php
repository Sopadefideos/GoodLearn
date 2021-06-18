@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Modificar Usuario')])
@if (session('data')['rol'] == 1)
@if (session('alert'))
  <script>alert('{{ session('alert') }}');</script>
@endif
@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="POST" action="updateUser" autocomplete="off" class="form-horizontal">
            @csrf
            @method('put')
            <div class="card ">
              <div class="card-header card-header-primary" style="background: #0D2F58">
                <h4 class="card-title" style="color: #C99255 !important">{{ __('Crear un nuevo usuario') }}</h4>
                <p class="card-category">{{ __('Informacion del usuario') }}</p>
              </div>
              <div class="card-body ">
                <div class="row">
                  <label class="col-sm-2 col-form-label">Nombre</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="name" id="input-name" type="text" placeholder="{{$usuario['name']}}" value="{{$usuario['name']}}" aria-required="true"/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="email" id="input-name" type="email" placeholder="{{$usuario['email']}}" value="{{$usuario['email']}}" aria-required="true"/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Telefono</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="telefono" id="input-telefono" type="text" placeholder="{{$usuario['telefono']}}" value="{{$usuario['telefono']}}" aria-required="true"/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Direccion</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="direccion" id="input-direccion" type="text" placeholder="{{$usuario['direccion']}}" value="{{$usuario['direccion']}}" aria-required="true"/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Contraseña</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="password" id="input-contraseña" type="password" placeholder="" value="" aria-required="true"/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Repite la Contraseña</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="password2" id="input-contraseña2" type="password" placeholder="" value="" aria-required="true"/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Rol</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <select class="form-control" name="rol" id="input-rol" type="text" placeholder="value="{{$usuario['rol_id']['name']}}" value="{{$usuario['rol_id']['name']}}">
                        @foreach ($roles as $rol)
                        <option>{{$rol['name']}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                
              </div>    
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary" style="background: #0D2F58; color: #C99255 !important">{{ __('Save') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
@endsection
@else
<script>
  window.location = "{{ route('admin') }}";
</script>
@endif