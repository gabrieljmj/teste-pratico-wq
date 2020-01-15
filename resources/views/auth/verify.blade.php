@extends('template.base')

@section('title', 'Verifique seu e-mail')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Verifique seu e-mail</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            Um novo link de confirmação foi enviado para seu e-mail.
                        </div>
                    @endif

                    Antes de prosseguir, por favor verifique seu e-mail.
                    Se você não recebeu o e-mail,
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">clique aqui para enviar outro</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
