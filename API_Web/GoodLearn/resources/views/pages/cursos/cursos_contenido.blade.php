@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __($curso['name'])])
@if (session('data')['rol'] == 1)
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-tabs card-header-primary">
            <div class="nav-tabs-navigation">
              <div class="nav-tabs-wrapper">
                <span class="nav-tabs-title">Opciones:</span>
                <ul class="nav nav-tabs" data-tabs="tabs">
                  <li class="nav-item">
                    <a class="nav-link active" href="#asignaturas" data-toggle="tab">
                      <i class="material-icons">subject</i> Asignaturas
                      <div class="ripple-container"></div>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#alumnos" data-toggle="tab">
                      <i class="material-icons">people_alt</i> Alumnos
                      <div class="ripple-container"></div>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="asignaturas">
                <a href="{{route('curso.asignatura.create', $curso['id'])}}">
                  <p class="card-category float-right"><span class="material-icons" style="margin-top: -15%;">
                    add
                  </span> Asignatura 
                  </p>
                </a>
                <table class="table">
                  <thead class="text-warning">
                    <th>Nombre</th>
                    <th>Profesor</th>
                    <th>Opciones</th>
                  </thead>
                  <tbody>
                      @foreach ($asignaturas as $asignatura)
                      <tr>
                        <td>{{$asignatura['asignatura_id']['nombre']}}</td>
                        <td>{{$asignatura['asignatura_id']['usuario_id']['name']}}</td>
                        <td class="td-actions text-right">
                          <a href="{{route('curso.asignatura.edit', ['curso' => $curso['id'], 'asignaturas_cursos' => $asignatura['id']])}}">
                            <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                              <i class="material-icons">edit</i>
                            </button>
                          </a>
                          <form method="POST" action="{{route('curso.asignatura.delete', ['asignaturas_cursos' => $asignatura['id']])}}" autocomplete="off" class="form-horizontal">
                            @csrf
                            @method('delete')
                            <button type="submit" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                              <i class="material-icons">close</i>
                            </button>
                          </form>
                        </td>
                      </tr>
                      @endforeach
                  </tbody>
                </table>
              </div>
              <div class="tab-pane" id="alumnos">
                <a href="{{route('curso.alumno.create', $curso)}}">
                  <p class="card-category float-right"><span class="material-icons" style="margin-top: -15%;">
                    add
                  </span> Alumno 
                  </p>
                </a>
                <table class="table">
                  <thead class="text-warning">
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Opciones</th>
                  </thead>
                  <tbody>
                      @foreach ($alumnos as $alumno)
                      <tr>
                        <td>{{$alumno['usuario_id']['name']}}</td>
                        <td>{{$alumno['usuario_id']['email']}}</td>
                        <td class="td-actions text-right">
                          <a href="{{route('curso.alumno.edit', ['curso' => $curso['id'], 'curso_alumno' => $alumno['id']])}}">
                            <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                              <i class="material-icons">edit</i>
                            </button>
                          </a>
                          <form method="POST" action="{{route('curso.alumno.delete', ['curso_alumno' => $alumno['id']])}}" autocomplete="off" class="form-horizontal">
                            @csrf
                            @method('delete')
                            <button type="submit" rel="tooltip" title="Remove" class="btn btn-danger btn-link btn-sm">
                              <i class="material-icons">close</i>
                            </button>
                          </form>
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
