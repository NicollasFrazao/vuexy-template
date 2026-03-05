{{--
    Data Table Component - Tabela de dados responsiva reutilizável
    
    Props:
    - title (string|null): Título do card que envolve a tabela. Opcional.
    - headers (array): Array de strings com os cabeçalhos da tabela
    - striped (bool): Se a tabela tem linhas alternadas. Default: false
    - hoverable (bool): Se as linhas têm efeito hover. Default: true
    - bordered (bool): Se a tabela tem bordas. Default: false
    - small (bool): Se a tabela usa padding reduzido. Default: false
    
    Slots:
    - default: Linhas da tabela (tr elements para o tbody)
    - headerActions: Ações no header do card (botões, filtros). Opcional.
    
    Uso:
    <x-data-table title="Users" :headers="['Name', 'Email', 'Role', 'Status', 'Actions']">
        <x-slot:headerActions>
            <button class="btn btn-sm btn-primary">Add User</button>
        </x-slot:headerActions>
        <tr>
            <td>John Doe</td>
            <td>john@example.com</td>
            <td>Admin</td>
            <td><span class="badge bg-label-success">Active</span></td>
            <td>...</td>
        </tr>
    </x-data-table>
--}}
@props([
    'title' => null,
    'headers' => [],
    'striped' => false,
    'hoverable' => true,
    'bordered' => false,
    'small' => false,
])

@php
    $tableClasses = 'table';
    if ($striped) $tableClasses .= ' table-striped';
    if ($hoverable) $tableClasses .= ' table-hover';
    if ($bordered) $tableClasses .= ' table-bordered';
    if ($small) $tableClasses .= ' table-sm';
@endphp

<div class="card">
    @if($title || isset($headerActions))
        <div class="card-header d-flex justify-content-between align-items-center">
            @if($title)
                <h5 class="card-title mb-0">{{ $title }}</h5>
            @endif
            @if(isset($headerActions))
                <div class="d-flex align-items-center gap-2">
                    {{ $headerActions }}
                </div>
            @endif
        </div>
    @endif
    <div class="table-responsive text-nowrap">
        <table class="{{ $tableClasses }}">
            @if(count($headers) > 0)
                <thead>
                    <tr>
                        @foreach($headers as $header)
                            <th>{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>
            @endif
            <tbody class="table-border-bottom-0">
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>
