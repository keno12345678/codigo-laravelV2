@extends('layout')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Servicios</h2>
        @auth
        <a href="{{ route('servicios.create') }}" class="btn btn-primary">Nuevo Servicio</a>
        @endauth
    </div>

    <div class="row">
        @if ($servicios->count())
            @foreach ($servicios as $servicio)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($servicio->image)
                    <img src="{{ asset('storage/'.$servicio->image) }}" class="card-img-top" alt="{{ $servicio->titulo }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $servicio->titulo }}</h5>
                        <p class="card-text">{{ Str::limit($servicio->descripcion, 100) }}</p>
                        <a href="{{ route('servicios.show', $servicio->id) }}" class="btn btn-primary">Ver más</a>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-12">
                <div class="alert alert-warning" role="alert">
                    No existe ningún servicio que mostrar.
                </div>
            </div>
        @endif
    </div>

    <div class="d-flex justify-content-center">
        {{ $servicios->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
