@extends('template.base')

@section('title', 'Cadastrar imóvel')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Editar imóvel</div>
                <div class="card-body">
                    <property-form v-bind:routes="routes" action="update" propertydata="{{ $property->toJson() }}"></property-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
