@extends('template.base')

@section('title', 'Cadastrar imóvel')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Cadastrar imóvel</div>
                <div class="card-body">
                    <property-form v-bind:routes="routes" action="create" propertydata="{{ json_encode([
                        'title' => old('title'),
                        'description' => old('description'),
                        'rent' => old('rent'),
                        'latitude' => old('latitude', 0),
                        'longitude' => old('longitude', 0),
                        'address' => [
                            'zip_code' => old('address.zip_code'),
                            'address' => old('address.adress'),
                            'number' => old('address.number'),
                            'district' => old('address.district'),
                            'city' => old('address.city'),
                            'state' => old('address.state'),
                        ],
                    ]) }}"></property-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
