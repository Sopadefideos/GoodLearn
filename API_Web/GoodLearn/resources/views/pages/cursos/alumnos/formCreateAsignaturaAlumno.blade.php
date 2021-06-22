@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Añadir alumno al Curso: '.$curso['name'])])
@if (session('data')['rol'] == 1)
@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="POST" action="{{route('curso.asignatura.store', $curso['id'])}}" autocomplete="off" class="form-horizontal">
            @csrf
            <div class="card ">
              <div class="card-header card-header-primary" style="background: #0D2F58">
                <h4 class="card-title" style="color: #C99255 !important">{{ __('Añadir alumno al curso') }}</h4>
                <p class="card-category">{{ __('Informacion sobre alumnos') }}</p>
              </div>
              <div class="card-body ">
                <div class="row">
                  <label class="col-sm-2 col-form-label">Alumno</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <select class="form-control" name="asignatura_id" id="input-rol" type="text">
                        @foreach ($asignaturas as $asignatura)
                        <option value="{{$asignatura['id']}}">{{$asignatura['nombre'].'  -  '.$asignatura['usuario_id']['name']}}
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