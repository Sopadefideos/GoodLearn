@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Padre')])
@if (session('data')['rol'] == 1)
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary" style="background: #0D2F58">
            <h4 class="card-title" style="color: #C99255 !important">Lista de hijos</h4>
            <p class="card-category">Informacion para los alumnos del sistema</p>
            <a href="{{route('padre.create', $padre)}}">
              <p class="card-category float-right"><span class="material-icons" style="margin-top: -15%;">
                person_add
              </span> Añadir Hijo 
              </p>
            </a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary" style="color: #000000 !important">
                  <th>
                    Nombre
                  </th>
                  <th>
                    Email
                  </th>
                  <th>
                    Telefono
                  </th>
                  <th>
                    Direccion
                  </th>
                  <th>
                    Opciones
                  </th>
                  <th>
  
                  </th>
                </thead>
                <tbody>
                  @foreach ($padres as $alumno)
                  <tr>
                    <td>
                      {{$alumno['alumno_id']['name']}}
                    </td>
                    <td>
                      {{$alumno['alumno_id']['email']}}
                    </td>
                    <td>
                      {{$alumno['alumno_id']['telefono']}}
                    </td>
                    <td>
                      {{$alumno['alumno_id']['direccion']}}
                    </td>
                    <td>
                      <form method="POST" action="{{route('padre.destroy', $alumno['id'])}}" autocomplete="off" class="form-horizontal">
                        @csrf
                        @method('delete')
                      <button type="submit" class="btn btn-primary" style="background: #9a2e52; color: #000000 !important"><span class="material-icons">
                        person_remove
                      </span></button>
                      </form>
                    </td>
                    <td>
                      <a href="{{route('padre.edit', $alumno['id'])}}"><button type="submit" class="btn btn-primary" style="background: #2f57b6; color: #000000 !important"><span class="material-icons">
                        edit
                        </span></button></a>
                    </td>
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
