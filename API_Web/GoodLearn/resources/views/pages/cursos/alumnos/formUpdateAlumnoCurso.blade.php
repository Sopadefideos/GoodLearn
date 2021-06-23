@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Modificar alumno del Curso: '.$curso['name'])])
@if (session('data')['rol'] == 1)
@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="POST" action="{{route('curso.alumno.update', ['curso_alumno' => $curso_alumno['id']])}}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('put')
            <div class="card ">
              <div class="card-header card-header-primary" style="background: #0D2F58">
                <h4 class="card-title" style="color: #C99255 !important">{{ __('Modificar alumno del curso') }}</h4>
                <p class="card-category">{{ __('Informacion sobre alumnos') }}</p>
              </div>
              <div class="card-body ">
                <div class="row">
                  <label class="col-sm-2 col-form-label">Alumno</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <select class="form-control" name="alumno_id" id="input-rol" type="text">
                        @foreach ($alumnos as $alumno)
                        <option value="{{$alumno['id']}}" @if ($alumno['id'] == $curso_alumno['usuario_id'])
                        selected
                      @endif>{{$alumno['name'].'  -  '.$alumno['email']}}
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