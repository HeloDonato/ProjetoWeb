@extends('layouts.login')

@section('content')
<div class="container-fluid fundo-TCS">
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="fundo-img">
                    <img src="{{ asset('img/servidores.png') }}" id="img-servidores">
                </div>
            </div>
            <div class="col-md-6 div-formCS">
                <div class="tit-form col-md-8">
                    <h1 class="tit-form-ser">Servidores</h1>
                </div>
    
                <form>
                    <div class="mb-3 col-md-8">
                        <input type="text" class="form-control cad-servidor" placeholder="Nome">
                    </div>
                    <div class="mb-3 col-md-8">
                        <input type="text" class="form-control cad-servidor" placeholder="Sobrenome">
                    </div>
                    <div class="mb-3 col-md-8">
                        <input type="email" class="form-control cad-servidor" placeholder="E-mail">
                    </div>
                    <div class="mb-3 col-md-8">
                        <input type="text" class="form-control cad-servidor" placeholder="Cargo">
                    </div>
                    <div class="lign-bottom col-md-8">
                        <button type="submit" class="btn btn-enviar">Enviar</button>
                    </div>
                    
                </form>
            </div>
        </div>
        
    </div>
</div>
@endsection
