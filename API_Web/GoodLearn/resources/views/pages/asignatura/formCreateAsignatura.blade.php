@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Crear Asignatura')])
@if (session('data')['rol'] == 1)
@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="POST" action="{{route('asignatura.store')}}" autocomplete="off" class="form-horizontal">
            @csrf
            <div class="card ">
              <div class="card-header card-header-primary" style="background: #0D2F58">
                <h4 class="card-title" style="color: #C99255 !important">{{ __('Crear una nueva asignatura') }}</h4>
                <p class="card-category">{{ __('Informacion de la asignatura') }}</p>
              </div>
              <div class="card-body ">
                <div class="row">
                  <label class="col-sm-2 col-form-label">Nombre</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="nombre" id="input-name" type="text" placeholder="Matematicas 2º Primaria" value="" required="true" aria-required="true"/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Profesor</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <select class="form-control" name="usuario_id" id="input-rol" type="text">
                        @foreach ($profesores as $profesor)
                        <option value="{{$profesor['id']}}"> {{$profesor['name']}}
                        </option>
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
