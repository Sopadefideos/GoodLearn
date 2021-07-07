@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __($asignatura['nombre'])])
@if (session('data')['rol'] <= 2)
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
                    <a class="nav-link active" href="#pdf" data-toggle="tab">
                      <i class="material-icons">picture_as_pdf</i> Documento
                      <div class="ripple-container"></div>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#alumnos_aceptado" data-toggle="tab">
                      <i class="material-icons">check_circle</i> Alumnos Aceptados
                      <div class="ripple-container"></div>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#alumnos_cancelado" data-toggle="tab">
                      <i class="material-icons">cancel</i> Alumnos no Aceptados
                      <div class="ripple-container"></div>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="pdf">
                <embed src="/autorizaciones/{{$url_autorizacion}}" type="application/pdf" width="100%" height="600px" />
              </div>
              <div class="tab-pane" id="alumnos_aceptado">
                <table class="table">
                  <thead class="text-warning">
                    <th>Alumno</th>
                    <th>Email</th>
                    <th>Opciones</th>
                  </thead>
                  <tbody>
                      @foreach ($autorizaciones as $autorizacion)
                      @if ($autorizacion['estado'] != 0)
                      <tr>
                        <td>{{$autorizacion['usuario_id']['name']}}</td>
                        <td>{{$autorizacion['usuario_id']['email']}}</td>
                        <td class="td-actions text-right">
                          <form method="POST" action="{{route('asignatura.autorizacion.update', $autorizacion['id'])}}" autocomplete="off" class="form-horizontal">
                            @csrf
                            @method('put')
                            <input type="hidden" name="estado" id="" value="0">
                            <button type="submit" rel="tooltip" title="Cancelar autorizacion" class="btn btn-primary btn-link btn-sm" style="color: red">
                              <i class="material-icons">close</i>
                            </button>
                          </form>
                        </td>
                      </tr>
                      @endif
                      @endforeach
                  </tbody>
                </table>
              </div>
              <div class="tab-pane" id="alumnos_cancelado">
                <table class="table">
                  <thead class="text-warning">
                    <th>Alumno</th>
                    <th>Email</th>
                    <th>Opciones</th>
                  </thead>
                  <tbody>
                      @foreach ($autorizaciones as $autorizacion)
                      @if ($autorizacion['estado'] == 0)
                      <tr>
                        <td>{{$autorizacion['usuario_id']['name']}}</td>
                        <td>{{$autorizacion['usuario_id']['email']}}</td>
                        <td class="td-actions text-right">
                          <form method="POST" action="{{route('asignatura.autorizacion.update', $autorizacion['id'])}}" autocomplete="off" class="form-horizontal">
                            @csrf
                            @method('put')
                            <input type="hidden" name="estado" id="" value="1">
                            <button type="submit" rel="tooltip" title="Aceptar autorizacion" class="btn btn-primary btn-link btn-sm" style="color: green">
                              <i class="material-icons">task_alt</i>
                            </button>
                          </form>
                        </td>
                      </tr>
                      @endif
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
