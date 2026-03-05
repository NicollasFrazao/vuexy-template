{{--
    Card Component - Componente de card reutilizável
    
    Props:
    - title (string|null): Título do card header. Opcional.
    - class (string): Classes CSS adicionais para o card. Opcional.
    
    Slots:
    - default: Conteúdo principal do card body
    - header: Conteúdo customizado do header (substitui o title prop). Opcional.
    - footer: Conteúdo do card footer. Opcional.
    - headerActions: Ações no lado direito do header (dropdown, botões). Opcional.
    
    Uso:
    <x-card title="Recent Orders">
        <p>Card content here</p>
    </x-card>
    
    Com header customizado:
    <x-card>
        <x-slot:header>
            <h5 class="card-title mb-0">Custom Header</h5>
            <x-slot:headerActions>
                <button class="btn btn-sm btn-primary">Action</button>
            </x-slot:headerActions>
        </x-slot:header>
        Card body content
    </x-card>
--}}
@props([
    'title' => null,
])

<div {{ $attributes->merge(['class' => 'card']) }}>
    @if(isset($header) || $title || isset($headerActions))
        <div class="card-header d-flex justify-content-between align-items-center">
            @if(isset($header))
                {{ $header }}
            @elseif($title)
                <h5 class="card-title mb-0">{{ $title }}</h5>
            @endif
            @if(isset($headerActions))
                <div class="d-flex align-items-center gap-2">
                    {{ $headerActions }}
                </div>
            @endif
        </div>
    @endif

    <div class="card-body">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div>
