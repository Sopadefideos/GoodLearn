@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Usuarios')])
@if (session('data')['rol'] == 1)
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary" style="background: #0D2F58">
            <h4 class="card-title" style="color: #C99255 !important">Lista de usuarios</h4>
            <p class="card-category">Informacion para los usuarios del sistema</p>
            <a href="{{route('usuario.create')}}">
              <p class="card-category float-right"><span class="material-icons" style="margin-top: -15%;">
                person_add
              </span> Añadir Usuario 
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
                    Rol
                  </th>
                  <th>
                    Opciones
                  </th>
                  <th>
  
                  </th>
                </thead>
                <tbody>
                  @foreach ($usuarios as $usuario)
                  <tr>
                    <td>
                      {{$usuario['name']}}
                    </td>
                    <td>
                      {{$usuario['email']}}
                    </td>
                    <td>
                      {{$usuario['telefono']}}
                    </td>
                    <td>
                      {{$usuario['direccion']}}
                    </td>
                    <td>
                      {{$usuario['rol_id']['name']}}
                    </td>
                    <td>
                      <form method="POST" action="{{route('usuario.delete', $usuario['id'])}}" autocomplete="off" class="form-horizontal">
                        @csrf
                        @method('delete')
                      <button type="submit" class="btn btn-primary" style="background: #9a2e52; color: #000000 !important"><span class="material-icons">
                        person_remove
                      </span></button>
                      </form>
                    </td>
                    <td>
                      <a href="{{route('usuario.edit', $usuario['id'])}}"><button type="submit" class="btn btn-primary" style="background: #2f57b6; color: #000000 !important"><span class="material-icons">
                        edit
                        </span></button></a>
                      
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                  <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                  <a class="page-link" href="#">Next</a>
                </li>
              </ul>
            </nav>
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
