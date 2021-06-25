@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Modificar Publicacion')])
@if (session('data')['rol'] == 1)
@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="POST" action="{{route('publicacion.update', ['user' => session('data')['user_id'], 'publicacion' => $publicacion['id']])}}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('put')
            <div class="card ">
              <div class="card-header card-header-primary" style="background: #0D2F58">
                <h4 class="card-title" style="color: #C99255 !important">{{ __('Modificar una publicacion') }}</h4>
                <p class="card-category">{{ __('Informacion de la publicacion') }}</p>
              </div>
              <div class="card-body ">
                <div class="row">
                  <label class="col-sm-2 col-form-label">Titulo</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="titulo" id="input-name" type="text" placeholder="{{$publicacion['titulo']}}" value="" aria-required="true"/>
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