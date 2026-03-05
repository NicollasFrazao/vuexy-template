{{--
    Page Header Component - Cabeçalho de página com título e breadcrumb
    
    Props:
    - title (string): Título principal da página
    - subtitle (string|null): Subtítulo/descrição da página. Opcional.
    
    Slots:
    - breadcrumb: Itens do breadcrumb (li elements)
    - actions: Botões de ação no lado direito. Opcional.
    
    Uso:
    <x-page-header title="User List" subtitle="Manage your users">
        <x-slot:breadcrumb>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Users</li>
        </x-slot:breadcrumb>
        <x-slot:actions>
            <a href="#" class="btn btn-primary">Add User</a>
        </x-slot:actions>
    </x-page-header>
--}}
@props([
    'title' => '',
    'subtitle' => null,
])

<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1">{{ $title }}</h4>
        @if($subtitle)
            <p class="mb-0 text-muted">{{ $subtitle }}</p>
        @endif
        @if(isset($breadcrumb))
            <nav aria-label="breadcrumb" class="mt-1">
                <ol class="breadcrumb breadcrumb-style1 mb-0">
                    {{ $breadcrumb }}
                </ol>
            </nav>
        @endif
    </div>
    @if(isset($actions))
        <div class="d-flex align-content-center flex-wrap gap-3">
            {{ $actions }}
        </div>
    @endif
</div>
