@extends('template.base')

@section('title', 'Meus imóveis')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>Meus imóveis</div>
                        <a href="{{ route('properties.new') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Adicionar imóvel</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">

                    </table>
                    @if ($properties->count())
                        <properties-list v-bind:routes="routes" propertiesdata="{{ json_encode($properties->map(function ($property) {
                            return [
                                'id' => $property->id,
                                'title' => $property->title,
                                'rent' => $property->rent,
                            ];
                        })) }}"></properties-list>
                    @else
                        <div class="text-center">Você não tem imóveis cadastrados.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
