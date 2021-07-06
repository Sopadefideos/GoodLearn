@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Asignatura')])
@if (session('data')['rol'] <= 2)
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary" style="background: #0D2F58">
            <h4 class="card-title" style="color: #C99255 !important">Lista de asignaturas</h4>
            <p class="card-category">Informacion para las asignaturas</p>
            @if (session('data')['rol'] == 1)
            <a href="{{route('asignatura.create')}}">
              <p class="card-category float-right"><span class="material-icons" style="margin-top: -15%;">
                add
              </span> Añadir asignatura 
              </p>
            </a>
            @endif
            
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary" style="color: #000000 !important">
                  <th>
                    Nombre
                  </th>
                  <th>
                    Profesor
                  </th>
                  <th>
                    Opciones
                  </th>
                  @if (session('data')['rol'] == 1)
                  <th>
                    
                  </th>
                  <th></th>
                  @endif
                  
                </thead>
                <tbody>
                  @foreach ($asignaturas as $asignatura)
                  @if (session('data')['rol'] == 1)
                  <tr>
                    <td>
                      {{$asignatura['nombre']}}
                    </td>
                    <td>
                      {{$asignatura['usuario_id']['name']}}
                    </td>
                    <td>
                      <a href="{{route('asignatura.content', $asignatura['id'])}}"><button type="submit" class="btn btn-primary" style="background: #ffffff; color: #000000 !important"><span class="material-icons">
                        source
                      </span></button></a>
                    </td>
                  @endif
                  @if (session('data')['rol'] == 2 && $asignatura['usuario_id']['id'] == session('data')['user_id'])
                  <tr>
                    <td>
                      {{$asignatura['nombre']}}
                    </td>
                    <td>
                      {{$asignatura['usuario_id']['name']}}
                    </td>
                    <td>
                      <a href="{{route('asignatura.content', $asignatura['id'])}}"><button type="submit" class="btn btn-primary" style="background: #ffffff; color: #000000 !important"><span class="material-icons">
                        source
                      </span></button></a>
                    </td>
                  @endif
                    @if (session('data')['rol'] == 1)
                    <td>
                      <form method="POST" action="{{route('asignatura.delete', $asignatura['id'])}}" autocomplete="off" class="form-horizontal">
                        @csrf
                        @method('delete')
                      <button type="submit" class="btn btn-primary" style="background: #9a2e52; color: #000000 !important"><span class="material-icons">
                        delete
                      </span></button>
                      </form>
                    </td>
                    <td>
                      <a href="{{route('asignatura.edit', $asignatura['id'])}}"><button type="submit" class="btn btn-primary" style="background: #2f57b6; color: #000000 !important"><span class="material-icons">
                        edit
                        </span></button></a>
                    </td>
                    @endif
                  </tr>
                  @endforeach
                </tbody>
              </table>
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
