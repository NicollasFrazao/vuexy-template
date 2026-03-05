{{--
    Badge Component - Componente de badge/etiqueta reutilizável
    
    Props:
    - color (string): Cor do badge (primary, secondary, success, danger, warning, info, dark). Default: 'primary'
    - label (bool): Se usa estilo label (bg-label-*) em vez de sólido. Default: false
    - pill (bool): Se usa estilo pill (rounded-pill). Default: false
    - dot (bool): Se exibe apenas um ponto indicador. Default: false
    
    Slots:
    - default: Texto do badge
    
    Uso:
    <x-badge color="success">Active</x-badge>
    <x-badge color="warning" label>Pending</x-badge>
    <x-badge color="danger" pill>3</x-badge>
--}}
@props([
    'color' => 'primary',
    'label' => false,
    'pill' => false,
    'dot' => false,
])

@php
    $bgClass = $label ? 'bg-label-' . $color : 'bg-' . $color;
    $classes = 'badge ' . $bgClass;
    if ($pill) $classes .= ' rounded-pill';
    if ($dot) $classes .= ' badge-dot';
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
