@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Comentarios')])
@if (session('data')['rol'] == 1)
@section('content')
<div class="content">
  <div class="container-fluid">

    <div class="row d-flex justify-content-center">
      <div class="col-lg-10">
        <div class="card" style="background: #0D2F58">
          <div class="card-body">
            <h5 class="card-title" style="color: white">Editar comentario</h5>
            <form method="POST" action="{{route('publicacion.comentario.update', $comentario['id'])}}" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal ">
              @csrf
              @method('put')
              <div class="container">
                <div class="row">
                  <div class="col-sm">
                    <div class="form-group">
                      <label for="exampleFormControlTextarea1" style="color: #C99255 !important">Comentario</label>
                      <textarea class="form-control" placeholder="{{$comentario['comentario']}}" name="comentario" id="exampleFormControlTextarea1" rows="3" style="color: white"></textarea>
                    </div>
                  </div>
                  <div class="col-sm">
                    <div class="form-group d-flex justify-content-center">
                      <input type="hidden" name="usuario_id" value="{{session('data')['user_id']}}">
                      <input type="hidden" name="publicacion_id" value="{{$comentario['publicacion_id']}}">
                      <button type="submit" class="btn btn-primary" style="background: #ffffff; color: #0D2F58 !important">{{ __('editar') }}</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>   
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@else
<script>
  window.location = "{{ route('admin') }}";
</script> 
@endif
