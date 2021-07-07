@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Comentarios')])
@if (session('data')['rol'] <= 2)
@section('content')
<div class="content">
  <div class="container-fluid">

    <div class="row d-flex justify-content-center">
      <div class="col-lg-10">
        <div class="card" style="background: #0D2F58">
          <div class="card-body">
            <h5 class="card-title" style="color: white">Nuevo comentario</h5>
            <form method="POST" action="{{route('publicacion.comentario.store')}}" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal ">
              @csrf
              <div class="container">
                <div class="row">
                  <div class="col-sm">
                    <div class="form-group">
                      <label for="exampleFormControlTextarea1" style="color: #C99255 !important">Comentario</label>
                      <textarea class="form-control" name="comentario" id="exampleFormControlTextarea1" rows="3" style="color: white"></textarea>
                    </div>
                  </div>
                  <div class="col-sm">
                    <div class="form-group d-flex justify-content-center">
                      <input type="hidden" name="usuario_id" value="{{session('data')['user_id']}}">
                      <input type="hidden" name="publicacion_id" value="{{$publicacion['id']}}">
                      <button type="submit" class="btn btn-primary" style="background: #ffffff; color: #0D2F58 !important">{{ __('comentar') }}</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>   
          </div>
        </div>
      </div>
    </div>
    @foreach ($comentarios as $comentario)
    <div class="card">
      <div class="card-head d-flex justify-content-between">
        <h5 class="card-title font-weight-bold align-self-center" style="margin-left: 2%">{{$comentario['usuario_id']['name']}}</h5>
        <div class="dropdown">
          <button class="btn btn-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="material-icons">more_horiz</i>
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="{{route('publicacion.comentario.edit', $comentario['id'])}}">Editar comentario</a>
            <form method="POST" id="my_form" action="{{route('publicacion.comentario.delete', ['user' => session('data')['user_id'], 'comentario' => $comentario['id']+1])}}" autocomplete="off" class="form-horizontal">
              @csrf
              @method('delete')
              <a class="dropdown-item" href="javascript:{}" onclick="document.getElementById('my_form').submit();">Eliminar</a>
            </form>
          </div>
        </div>
      </div>
      <div class="card-body">
        <blockquote class="blockquote mb-0">
          <p>{{$comentario['comentario']}}</p>
          <footer class="blockquote-footer"><p class="card-text"><small class="text-muted" style="color: #C99255 !important">Last updated {{ \Carbon\Carbon::parse($comentario['fecha_creacion'])->diffForHumans(null, false, false, 1)}}</small></p></footer>
        </blockquote>
      </div>
    </div>
    @endforeach
    
  </div>
</div>
@endsection
@else
<script>
  window.location = "{{ route('admin') }}";
</script> 
@endif
