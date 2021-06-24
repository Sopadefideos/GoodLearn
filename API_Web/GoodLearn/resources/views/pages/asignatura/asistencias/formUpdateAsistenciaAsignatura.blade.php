@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Modificar falta de asistencia a: '.$asignatura['nombre'])])
@if (session('data')['rol'] == 1)
@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="POST" action="{{route('asignatura.asistencia.update', $asistencia['id'])}}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('put')
            <div class="card ">
              <div class="card-header card-header-primary" style="background: #0D2F58">
                <h4 class="card-title" style="color: #C99255 !important">{{ __('Modificar falta de asistencia a la asignatura') }}</h4>
                <p class="card-category">{{ __('Informacion sobre falta de asistencia') }}</p>
              </div>
              <div class="card-body ">
                <div class="row">
                  <label class="col-sm-2 col-form-label">Alumno</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <select class="form-control" name="usuario_id" id="input-rol" type="text">
                        @foreach ($alumnos as $alumno)
                        <option value="{{$alumno['usuario_id']['id']}}" @if ($alumno['usuario_id']['id'] == $asistencia['usuario_id'])
                        selected
                      @endif>{{$alumno['usuario_id']['name'].'  -  '.$alumno['usuario_id']['email']}}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Fecha de la falta</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="fecha_falta" id="input-name" type="date" placeholder="{{$asistencia['fecha_falta']}}" value="" aria-required="true"/>
                    </div>
                  </div>
                </div>
              </div>    
              <div class="card-footer ml-auto mr-auto">
                <input class="form-control" name="asignatura_id" id="input-name" type="hidden" placeholder="pepito@hotmail.com" value="{{$asignatura['id']}}" aria-required="true"/>
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