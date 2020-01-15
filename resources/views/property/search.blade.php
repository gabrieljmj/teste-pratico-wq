@extends('template.base')

@section('title', 'Pesquisar imóvel')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Pesquisar imóvel</div>
                <div class="card-body">
                    <properties-search v-bind:routes="routes"></properties-search>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
