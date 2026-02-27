@extends('layouts.app')

@section('title', 'Test Layout - Verificação de Componentes')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Teste de Layout e Componentes</h5>
            </div>
            <div class="card-body">
                <p class="mb-3">Esta é uma página de teste temporária para verificar que todos os componentes do layout estão sendo renderizados corretamente.</p>
                
                <h6>Componentes Verificados:</h6>
                <ul>
                    <li>✓ Layout principal (app.blade.php)</li>
                    <li>✓ Sidebar (componente x-sidebar)</li>
                    <li>✓ Navbar (componente x-navbar)</li>
                    <li>✓ Footer (componente x-footer)</li>
                    <li>✓ Assets CSS compilados</li>
                    <li>✓ Assets JavaScript compilados</li>
                </ul>

                <div class="alert alert-success mt-3" role="alert">
                    <h6 class="alert-heading mb-1">Sucesso!</h6>
                    <p class="mb-0">Se você está vendo esta página com o layout completo do Vuexy, todos os componentes estão funcionando corretamente.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
