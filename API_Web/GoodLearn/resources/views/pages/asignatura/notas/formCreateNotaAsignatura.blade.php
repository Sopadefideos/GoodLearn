@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Añadir calificacion a: '.$asignatura['nombre'])])
@if (session('data')['rol'] <= 2)
@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="POST" action="{{route('asignatura.nota.store', $asignatura['id'])}}" autocomplete="off" class="form-horizontal">
            @csrf
            <div class="card ">
              <div class="card-header card-header-primary" style="background: #0D2F58">
                <h4 class="card-title" style="color: #C99255 !important">{{ __('Añadir calificacion a la asignatura') }}</h4>
                <p class="card-category">{{ __('Informacion sobre calificacion') }}</p>
              </div>
              <div class="card-body ">
                <div class="row">
                  <label class="col-sm-2 col-form-label">Alumno</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <select class="form-control" name="usuario_id" id="input-rol" type="text">
                        @foreach ($alumnos as $alumno)
                        <option value="{{$alumno['usuario_id']['id']}}">{{$alumno['usuario_id']['name'].'  -  '.$alumno['usuario_id']['email']}}
                        </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Titulo</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="titulo" id="input-name" type="text" placeholder="Examen 1er Tema" value="" required="true" aria-required="true"/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Cuerpo</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="cuerpo" id="input-name" type="text" placeholder="Ha superado todo los ejercicios, excepto el calculo de ecuaciones." value="" required="true" aria-required="true"/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Nota</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="nota" id="input-name" type="number" min="0" max="10" placeholder="0 - 10" value="" required="true" aria-required="true"/>
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