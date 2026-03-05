{{--
    Alert Component - Componente de alerta reutilizável
    
    Props:
    - type (string): Tipo do alerta Bootstrap (primary, secondary, success, danger, warning, info, dark). Default: 'primary'
    - dismissible (bool): Se o alerta pode ser fechado. Default: false
    - icon (string|null): Classe do ícone Tabler. Opcional.
    - title (string|null): Título em negrito do alerta. Opcional.
    
    Slots:
    - default: Conteúdo do alerta
    
    Uso:
    <x-alert type="success" dismissible icon="tabler-check" title="Success!">
        Your changes have been saved.
    </x-alert>
--}}
@props([
    'type' => 'primary',
    'dismissible' => false,
    'icon' => null,
    'title' => null,
])

<div {{ $attributes->merge(['class' => 'alert alert-' . $type . ($dismissible ? ' alert-dismissible' : '') . ' d-flex align-items-center']) }} role="alert">
    @if($icon)
        <span class="alert-icon me-2">
            <i class="icon-base ti {{ $icon }}"></i>
        </span>
    @endif
    <div>
        @if($title)
            <h6 class="alert-heading mb-1">{{ $title }}</h6>
        @endif
        {{ $slot }}
    </div>
    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
