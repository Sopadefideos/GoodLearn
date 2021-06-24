@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __($asignatura['nombre'])])
@if (session('data')['rol'] == 1)
@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-tabs card-header-primary" style="background: #0D2F58">
            <div class="nav-tabs-navigation">
              <div class="nav-tabs-wrapper">
                <span class="nav-tabs-title">Opciones:</span>
                <ul class="nav nav-tabs" data-tabs="tabs">
                  <li class="nav-item">
                    <a class="nav-link active" href="#asistencias" data-toggle="tab">
                      <i class="material-icons">event</i> F.Asistencias
                      <div class="ripple-container"></div>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#notas" data-toggle="tab">
                      <i class="material-icons">assignment</i> Calificaciones
                      <div class="ripple-container"></div>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#autorizaciones" data-toggle="tab">
                      <i class="material-icons">assignment_ind</i> Autorizaciones
                      <div class="ripple-container"></div>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#contenidos" data-toggle="tab">
                      <i class="material-icons">menu_book</i> Contenidos
                      <div class="ripple-container"></div>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="asistencias">
                <a href="{{route('asignatura.asistencia.create', $asignatura['id'])}}">
                  <p class="card-category float-right"><span class="material-icons" style="margin-top: -15%;">
                    add
                  </span> F.Asistencia
                  </p>
                </a>
                <table class="table">
                  <thead class="text-warning">
                    <th>Alumno</th>
                    <th>Falta de asistencia</th>
                    <th>Opciones</th>
                  </thead>
                  <tbody>
                      @foreach ($asistencias as $asistencia)
                      <tr>
                        <td>{{$asistencia['usuario_id']['name']}}</td>
                        <td>{{date('Y-m-d', strtotime($asistencia['fecha_falta']))}}</td>
                        <td class="td-actions text-right">
                          <a href="{{route('asignatura.asistencia.edit', ['asignatura' => $asignatura['id'], 'asistencia' => $asistencia['id']])}}">
                            <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                              <i class="material-icons">edit</i>
                            </button>
                          </a>
                          <form method="POST" action="{{route('asignatura.asistencia.delete', $asistencia['id'])}}" autocomplete="off" class="form-horizontal">
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
              <div class="tab-pane" id="notas">
                <a href="{{route('asignatura.nota.create', $asignatura['id'])}}">
                  <p class="card-category float-right"><span class="material-icons" style="margin-top: -15%;">
                    add
                  </span> Nota
                  </p>
                </a>
                <table class="table">
                  <thead class="text-warning">
                    <th>Alumno</th>
                    <th>Nota</th>
                    <th>Opciones</th>
                  </thead>
                  <tbody>
                      @foreach ($notas as $nota)
                      <tr>
                        <td>{{$nota['usuario_id']['name']}}</td>
                        <td>
                          <div class="col-sm-12">
                            <div class="card">
                              <div class="card-body">
                                <h5 class="card-title">{{$nota['titulo']}}</h5>
                                <p class="card-text">{{$nota['cuerpo']}}</p>
                                <button href="" class="btn btn-primary" style="background: #C99255;">{{$nota['nota']}}</button>
                              </div>
                            </div>
                          </div>
                        </td>
                        <td class="td-actions text-right">
                          <a href="{{route('asignatura.nota.edit', ['asignatura' => $asignatura['id'], 'nota' => $nota['id']])}}">
                            <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                              <i class="material-icons">edit</i>
                            </button>
                          </a>
                          <form method="POST" action="{{route('asignatura.nota.delete', $nota['id'])}}" autocomplete="off" class="form-horizontal">
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
              <div class="tab-pane" id="autorizaciones">
                <a href="{{route('asignatura.autorizacion.create', $asignatura['id'])}}">
                  <p class="card-category float-right"><span class="material-icons" style="margin-top: -15%;">
                    add
                  </span> Autorizacion
                  </p>
                </a>
                <table class="table">
                  <thead class="text-warning">
                    <th>Autorizacion</th>
                    <th>Fecha de creacion</th>
                    <th>Opciones</th>
                  </thead>
                  <tbody>
                      @foreach ($autorizaciones as $clave => $autorizacion)
                      <tr>
                        <td><a href="{{route('asignatura.autorizacion.content', ['url_name' => $clave, 'asignatura' => $asignatura['id']])}}" class="btn btn-primary" style="background: #C99255;">{{$clave}}</a></td>
                        <td>{{date('Y-m-d', strtotime($autorizacion[0]['fecha_creacion']))}}</td>
                        <td class="td-actions text-right">
                          <a href="{{route('asignatura.autorizacion.edit', ['asignatura' => $asignatura['id'], 'autorizacion' =>$autorizacion[0]['id']])}}">
                            <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                              <i class="material-icons">edit</i>
                            </button>
                          </a>
                          <form method="POST" action="{{route('asignatura.autorizacion.delete', $autorizacion[0]['id'])}}" autocomplete="off" class="form-horizontal">
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
              <div class="tab-pane" id="contenidos">
                <a href="{{route('asignatura.contenido.create', $asignatura['id'])}}">
                  <p class="card-category float-right"><span class="material-icons" style="margin-top: -15%;">
                    add
                  </span> Contenido
                  </p>
                </a>
                <table class="table">
                  <thead class="text-warning">
                    <th>Contenido</th>
                    <th>Fecha de creacion</th>
                    <th>Opciones</th>
                  </thead>
                  <tbody>
                      @foreach ($contenidos as $clave => $contenido)
                      <tr>
                        <td><a href="{{route('asignatura.contenido.content', ['url_name' => $clave, 'asignatura' => $asignatura['id']])}}" class="btn btn-primary" style="background: #C99255;">{{$clave}}</a></td>
                        <td>{{date('Y-m-d', strtotime($contenido[0]['fecha_creacion']))}}</td>
                        <td class="td-actions text-right">
                          <a href="{{route('asignatura.contenido.edit', ['asignatura' => $asignatura['id'], 'contenido' =>$contenido[0]['id']])}}">
                            <button type="button" rel="tooltip" title="Edit Task" class="btn btn-primary btn-link btn-sm">
                              <i class="material-icons">edit</i>
                            </button>
                          </a>
                          <form method="POST" action="{{route('asignatura.contenido.delete', $contenido[0]['id'])}}" autocomplete="off" class="form-horizontal">
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
  </div>
</div>
@endsection
@else
<script>
  window.location = "{{ route('admin') }}";
</script>
@endif
