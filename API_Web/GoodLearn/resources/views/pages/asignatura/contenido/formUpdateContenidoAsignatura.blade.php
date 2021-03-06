@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Modificar contenido a: '.$asignatura['nombre'])])
@if (session('data')['rol'] <= 2)
@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="POST" action="{{route('asignatura.contenido.update', $contenido['id'])}}" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal">
            @csrf
            @method('put')
            <div class="card ">
              <div class="card-header card-header-primary" style="background: #0D2F58">
                <h4 class="card-title" style="color: #C99255 !important">{{ __('Modificar contenido a la asignatura') }}</h4>
                <p class="card-category">{{ __('Informacion sobre contenido') }}</p>
              </div>
              <div class="card-body ">
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="customInput">Contenido (PDF)</label>
                  <div class=" col-sm-6">
                    <input type="file" name="contenido_file" class="form-control" id="customInput" required>
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