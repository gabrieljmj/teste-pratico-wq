@extends('template.base')

@section('title', $property->title)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">Imóvel</div>
                <div class="card-body">
                    <property v-bind:property="{{ $property->toJson() }}"></property>
                </div>
            </div>

            <div class="card mt-2">
                <div class="card-header">Próximos</div>
                <div class="card-body">
                    @if ($nearby->count())
                        <properties-inline-list v-bind:routes="routes" v-bind:properties="{{ json_encode($nearby->map(function ($property) {
                            return [
                                'id' => $property->id,
                                'title' => $property->title,
                                'rent' => $property->rent,
                                'picture' => $property->picture,
                            ];
                        })) }}"></properties-inline-list>
                    @else
                        <div class="text-center">Não encontrado nenhum imóvel proóximo a esse.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
