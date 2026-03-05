{{--
    Stat Card Component - Cartão de estatística reutilizável
    
    Props:
    - title (string): Título/label da estatística
    - value (string): Valor principal a exibir
    - icon (string): Classe do ícone Tabler (ex: 'tabler-users')
    - color (string): Cor do badge (primary, success, danger, warning, info, secondary). Default: 'primary'
    - trend (string|null): Texto de tendência (ex: '+12%'). Opcional.
    - trend-type (string): Tipo de tendência para cor: 'up' (success) ou 'down' (danger). Default: 'up'
    - subtitle (string|null): Texto secundário abaixo do valor. Opcional.
    
    Uso:
    <x-stat-card title="Total Users" value="1,234" icon="tabler-users" color="primary" trend="+12%" subtitle="Last month" />
--}}
@props([
    'title' => '',
    'value' => '',
    'icon' => 'tabler-chart-bar',
    'color' => 'primary',
    'trend' => null,
    'trendType' => 'up',
    'subtitle' => null,
])

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <div class="card-info">
                <p class="card-text">{{ $title }}</p>
                <div class="d-flex align-items-end mb-2">
                    <h4 class="card-title mb-0 me-2">{{ $value }}</h4>
                    @if($trend)
                        <small class="text-{{ $trendType === 'down' ? 'danger' : 'success' }}">{{ $trend }}</small>
                    @endif
                </div>
                @if($subtitle)
                    <small class="text-muted">{{ $subtitle }}</small>
                @endif
            </div>
            <div class="card-icon">
                <span class="badge bg-label-{{ $color }} rounded p-2">
                    <i class="icon-base ti {{ $icon }} icon-sm"></i>
                </span>
            </div>
        </div>
    </div>
</div>
