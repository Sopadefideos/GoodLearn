@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Publicaciones')])
@if (session('data')['rol'] == 1)
@section('content')
<div class="content">
  <div class="container-fluid">

    <div class="row d-flex justify-content-center">
      <div class="col-lg-10">
        <div class="card" style="background: #0D2F58">
          <div class="card-body">
            <h5 class="card-title" style="color: white">Nueva publicacion</h5>
            <form method="POST" action="{{route('publicacion.store', session('data')['user_id'])}}" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal ">
              @csrf
              <div class="container">
                <div class="row">
                  <div class="col-sm">
                    <div class="form-group">
                      <label for="exampleFormControlTextarea1" style="color: #C99255 !important">Titulo de la publicacion</label>
                      <textarea class="form-control" name="titulo" id="exampleFormControlTextarea1" rows="3" style="color: white"></textarea>
                    </div>
                  </div>
                  <div class="col-sm">
                    <div class="form-group">
                      <label for="exampleFormControlInput1" style="color: #C99255 !important">Imagen</label>
                    </div>
                    <input type="hidden" name="email" value="{{session('data')['email']}}">
                    <input type="file" name="img" class="form-control" id="exampleFormControlInput1" required style="color: white">
                  </div>
                  <div class="col-sm">
                    <div class="form-group d-flex justify-content-center">
                      <button type="submit" class="btn btn-primary" style="background: #ffffff; color: #0D2F58 !important">{{ __('Publicar') }}</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>   
          </div>
        </div>
      </div>
    </div>
    @foreach ($publicaciones as $publicacion)
    <div class="row d-flex justify-content-center">
      <div class="col-lg-6 ">
        <div class="card mb-3 ">
          <div class="card-head d-flex justify-content-between">
            <h5 class="card-title font-weight-bold align-self-center" style="margin-left: 2%">{{$publicacion['usuario_id']['name']}}</h5>
            <div class="dropdown">
              <button class="btn btn-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="material-icons">more_horiz</i>
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{route('publicacion.edit', $publicacion['id'])}}">Editar titulo</a>
                <form method="POST" id="my_form" action="{{route('publicacion.delete', ['user' => session('data')['user_id'], 'publicacion' => $publicacion['id']])}}" autocomplete="off" class="form-horizontal">
                  @csrf
                  @method('delete')
                  <a class="dropdown-item" href="javascript:{}" onclick="document.getElementById('my_form').submit();">Eliminar</a>
                </form>
              </div>
            </div>
          </div>
          
          <img src="/publicaciones/{{$publicacion['url_img']}}" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title font-weight-bold" style="color: #0D2F58 !important">{{$publicacion['titulo']}}</h5>
            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
            <p class="card-text"><small class="text-muted" style="color: #C99255 !important">Last updated {{ \Carbon\Carbon::parse($publicacion['fecha_creacion'])->diffForHumans(null, false, false, 1)}}</small></p>
          </div>
        </div>
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
