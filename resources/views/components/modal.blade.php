{{--
    Modal Component - Componente de modal Bootstrap reutilizável
    
    Props:
    - id (string): ID único do modal (obrigatório para controle via JS)
    - title (string): Título do modal header
    - size (string|null): Tamanho do modal: 'sm', 'lg', 'xl'. Opcional (padrão é médio).
    - scrollable (bool): Se o conteúdo do modal é scrollable. Default: false
    - centered (bool): Se o modal é centralizado verticalmente. Default: false
    - staticBackdrop (bool): Se o modal não fecha ao clicar fora. Default: false
    
    Slots:
    - default: Conteúdo do modal body
    - footer: Conteúdo do modal footer. Opcional.
    
    Uso:
    <x-modal id="confirmModal" title="Confirm Action" size="sm">
        Are you sure you want to proceed?
        <x-slot:footer>
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary">Confirm</button>
        </x-slot:footer>
    </x-modal>
    
    Trigger button:
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal">
        Open Modal
    </button>
--}}
@props([
    'id' => 'modal-' . uniqid(),
    'title' => '',
    'size' => null,
    'scrollable' => false,
    'centered' => false,
    'staticBackdrop' => false,
])

@php
    $dialogClasses = 'modal-dialog';
    if ($size) $dialogClasses .= ' modal-' . $size;
    if ($scrollable) $dialogClasses .= ' modal-dialog-scrollable';
    if ($centered) $dialogClasses .= ' modal-dialog-centered';
@endphp

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-hidden="true"
    @if($staticBackdrop) data-bs-backdrop="static" data-bs-keyboard="false" @endif>
    <div class="{{ $dialogClasses }}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            @if(isset($footer))
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
