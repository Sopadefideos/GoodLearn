@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'home', 'title' => __('GoodLearn')])

@if (!session()->has('data'))
@section('content')
<div class="container" style="height: auto;">
  <div class="row justify-content-center">
      <div class="col-lg-7 col-md-8">
          <h1 class="text-white text-center">{{ __('Bienvenidos a GoodLearn el sistema para centros educativos preferido por muchos.') }}</h1>
      </div>
  </div>
</div>
@endsection
@else
<script>
  window.location = "{{ route('home') }}";
</script>
@endif

