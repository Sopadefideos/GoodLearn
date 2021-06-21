@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Asignatura')])
@if (session('data')['rol'] == 1)
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary" style="background: #0D2F58">
            <h4 class="card-title" style="color: #C99255 !important">Lista de asignaturas</h4>
            <p class="card-category">Informacion para las asignaturas</p>
            <a href="{{route('asignatura.create')}}">
              <p class="card-category float-right"><span class="material-icons" style="margin-top: -15%;">
                person_add
              </span> Añadir asignatura 
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
                    Profesor
                  </th>
                  <th>
                    Opciones
                  </th>
                </thead>
                <tbody>
                  @foreach ($asignaturas as $asignatura)
                    <td>
                      {{$asignatura['nombre']}}
                    </td>
                    <td>
                      {{$asignatura['usuario_id']['name']}}
                    </td>
                    <td>
                      <form method="POST" action="{{route('asignatura.delete', $asignatura['id'])}}" autocomplete="off" class="form-horizontal">
                        @csrf
                        @method('delete')
                      <button type="submit" class="btn btn-primary" style="background: #9a2e52; color: #000000 !important"><span class="material-icons">
                        delete
                      </span></button>
                    </form>
                      <a href="{{route('asignatura.edit', $asignatura['id'])}}"><button type="submit" class="btn btn-primary" style="background: #2f57b6; color: #000000 !important"><span class="material-icons">
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
