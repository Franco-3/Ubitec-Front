@extends('backend.layouts.main')
@section('title', 'Vehiculo')
@section('content')
<div class="card mb-3">
    <div class="row no-gutters">
        <div class="col-md-7">
            <div class="card-body">
                <h5 class="card-title">{{ $vehiculo->nombre}}</h5>
                <p class="card-text">{!! $vehiculo->patente !!}</p>
            </div>
        </div>
    </div>
</div>
@endsection
