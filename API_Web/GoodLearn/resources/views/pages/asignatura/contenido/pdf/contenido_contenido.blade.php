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
                </ul>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="pdf">
                <embed src="/contenidos/{{$url_contenido}}" type="application/pdf" width="100%" height="600px" />
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
