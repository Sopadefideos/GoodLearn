@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Modificar Curso')])
@if (session('data')['rol'] == 1)
@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="POST" action="{{route('curso.update', $curso['id'])}}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('put')
            <div class="card ">
              <div class="card-header card-header-primary" style="background: #0D2F58">
                <h4 class="card-title" style="color: #C99255 !important">{{ __('Modificar el curso') }}</h4>
                <p class="card-category">{{ __('Informacion del curso') }}</p>
              </div>
              <div class="card-body ">
                <div class="row">
                  <label class="col-sm-2 col-form-label">Nombre</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="name" id="input-name" type="text" placeholder="{{$curso['name']}}" value="" aria-required="true"/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Fecha de comienzo</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="fecha_inicio" id="input-name" type="datetime-local" placeholder="{{$curso['fecha_inicio']}}" value="" aria-required="true"/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">Fecha de finalizacion</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="fecha_fin" id="input-telefono" type="datetime-local" placeholder="{{$curso['fecha_fin']}}" value="" aria-required="true"/>
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