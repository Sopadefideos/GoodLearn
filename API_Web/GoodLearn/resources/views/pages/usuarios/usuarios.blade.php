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
          </div>
        </div>
      </div>
  <!--
      <div class="col-md-12">
        <div class="card card-plain">
          <div class="card-header card-header-primary">
            <h4 class="card-title mt-0"> Table on Plain Background</h4>
            <p class="card-category"> Here is a subtitle for this table</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="">
                  <th>
                    ID
                  </th>
                  <th>
                    Name
                  </th>
                  <th>
                    Country
                  </th>
                  <th>
                    City
                  </th>
                  <th>
                    Salary
                  </th>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      1
                    </td>
                    <td>
                      Dakota Rice
                    </td>
                    <td>
                      Niger
                    </td>
                    <td>
                      Oud-Turnhout
                    </td>
                    <td>
                      $36,738
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  -->
  </div>
</div>
@endsection
@else
<script>
  window.location = "{{ route('admin') }}";
</script>
@endif
