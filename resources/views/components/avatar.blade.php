{{--
    Avatar Component - Componente de avatar reutilizável
    
    Props:
    - src (string|null): URL da imagem do avatar. Se não fornecido, usa iniciais.
    - name (string): Nome para gerar iniciais ou alt text. Default: 'User'
    - size (string|null): Tamanho: 'xs', 'sm', 'lg', 'xl'. Opcional (padrão é médio).
    - color (string): Cor do avatar com iniciais (primary, success, danger, warning, info). Default: 'primary'
    - status (string|null): Status online: 'online', 'offline', 'away', 'busy'. Opcional.
    - rounded (bool): Se usa borda arredondada em vez de circular. Default: false
    
    Uso:
    <x-avatar src="{{ asset('assets/img/avatars/1.png') }}" name="John Doe" status="online" />
    <x-avatar name="John Doe" color="primary" size="lg" />
--}}
@props([
    'src' => null,
    'name' => 'User',
    'size' => null,
    'color' => 'primary',
    'status' => null,
    'rounded' => false,
])

@php
    $avatarClasses = 'avatar';
    if ($size) $avatarClasses .= ' avatar-' . $size;
    if ($status) $avatarClasses .= ' avatar-' . $status;

    // Generate initials from name
    $parts = explode(' ', trim($name));
    $initials = strtoupper(substr($parts[0], 0, 1));
    if (count($parts) > 1) {
        $initials .= strtoupper(substr(end($parts), 0, 1));
    }

    $imgClasses = $rounded ? 'rounded' : 'rounded-circle';
@endphp

<div class="{{ $avatarClasses }}">
    @if($src)
        <img src="{{ $src }}" alt="{{ $name }}" class="h-auto {{ $imgClasses }}">
    @else
        <span class="avatar-initial {{ $imgClasses }} bg-label-{{ $color }}">{{ $initials }}</span>
    @endif
</div>
